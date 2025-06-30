<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Divisi;
use App\Models\Jurusan;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = SuratMasuk::with(['jurusan', 'user', 'disposisis']);

        if ($user->isAdmin()) {
        } elseif ($user->isSekretaris()) {
            $query->whereIn('status_surat', [
                'Diajukan',
                'Diverifikasi',
                'Ditolak',
                'Diproses',
                'Disetujui',
                'Terkirim',
                'Baru',
                'Dibaca',
                'Selesai',
                'Diarsipkan'
            ]);
        } elseif ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
            $disposisiSuratIds = Disposisi::where('user_penerima_id', $user->id)
                ->orWhere('divisi_penerima_id', $user->divisi_id)
                ->pluck('surat_masuk_id');

            $query->where(function ($q) use ($disposisiSuratIds) {
                $q->whereIn('status_surat', [
                    'Diproses',
                    'Disetujui',
                    'Terkirim',
                    'Baru',
                    'Dibaca',
                    'Selesai',
                    'Diarsipkan',
                    'Didisposisi'
                ])
                    ->orWhereIn('id', $disposisiSuratIds);
            });
        } elseif ($user->isOperator() && $user->jurusan_id) {
            $query->where('user_id', $user->id)
                ->where('jurusan_id', $user->jurusan_id);
        } else {
            $query->whereRaw('1 = 0');
        }

        // Pencarian
        $query->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                    ->orWhere('nomor_surat_pengirim', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        });

        // Filter status surat
        $query->when($request->status_surat, function ($query, $status) {
            $query->where('status_surat', $status);
        });

        $suratMasuks = $query->latest()->paginate(10)->withQueryString();

        foreach ($suratMasuks as $surat) {
            $status = $surat->status_surat;

            $adaDisposisiBaru = $surat->disposisis->contains(
                fn($d) =>
                $d->user_penerima_id == $user->id && $d->status_disposisi === 'Baru'
            );

            $surat->status_tampilan = match (true) {
                $adaDisposisiBaru => 'Baru',
                $status === 'Dibaca' => 'Dibaca',
                $status === 'Selesai' => 'Selesai',
                $status === 'Diarsipkan' => 'Diarsipkan',
                default => $status,
            };
            $surat->status_tampilan = $adaDisposisiBaru ? 'Baru' : $status;
        }
        $pimpinanUsers = User::whereIn('role', ['pimpinan'])->get(['id', 'name']);
        return view('surat_masuk.index', compact('suratMasuks', 'pimpinanUsers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'create');

        $jurusans = $user->isOperator() && $user->jurusan_id
            ? Jurusan::where('id', $user->jurusan_id)->get()
            : Jurusan::all();

        $divisis = Divisi::all();

        return view('surat_masuk.create', compact('jurusans', 'divisis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'store');

        $validated = $this->validateSuratMasuk($request, true);
        $validated['status_surat'] = 'Diajukan';

        if ($request->hasFile('file_surat')) {
            $this->handleFileUpload($request, $validated);
        }

        if ($user->isOperator() && $user->jurusan_id) {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        $validated['user_id'] = $user->id;
        SuratMasuk::create($validated);

        return redirect()->route('surat_masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'show', $suratMasuk);

        return view('surat_masuk.show', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'edit', $suratMasuk);

        $jurusans = $user->isOperator() && $user->jurusan_id
            ? Jurusan::where('id', $user->jurusan_id)->get()
            : Jurusan::all();

        $divisis = Divisi::all();

        return view('surat_masuk.edit', compact('suratMasuk', 'jurusans', 'divisis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'update', $suratMasuk);

        $validated = $this->validateSuratMasuk($request, false);
        unset($validated['status_surat']); // Status surat tidak boleh diubah dari form update biasa

        if ($request->hasFile('file_surat')) {
            if ($suratMasuk->file_surat_path && File::exists(public_path($suratMasuk->file_surat_path))) {
                File::delete(public_path($suratMasuk->file_surat_path));
            }
            $this->handleFileUpload($request, $validated);
        } else {
            $validated['file_surat_path'] = $suratMasuk->file_surat_path;
            $validated['nama_file_surat_asli'] = $suratMasuk->nama_file_surat_asli;
        }

        if ($user->isOperator() && $user->jurusan_id) {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        $suratMasuk->update($validated);

        return redirect()->route('surat_masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'delete', $suratMasuk);

        if ($suratMasuk->file_surat_path && File::exists(public_path($suratMasuk->file_surat_path))) {
            File::delete(public_path($suratMasuk->file_surat_path));
        }

        $suratMasuk->delete();

        return redirect()->route('surat_masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }

    public function print(SuratMasuk $suratMasuk)
    {
        $user = Auth::user();

        $authorized = $user->isAdmin() ||
            $suratMasuk->user_id === $user->id ||
            ($user->isOperator() && $user->jurusan_id === $suratMasuk->jurusan_id) ||
            $user->isSekretaris() ||
            $user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang();

        abort_unless($authorized, 403);

        if (in_array($suratMasuk->status_surat, ['Terkirim', 'Baru'])) {
            $suratMasuk->update(['status_surat' => 'Dibaca']);
        }

        $disposisi = $suratMasuk->disposisis
            ->where('user_penerima_id', $user->id)
            ->where('status_disposisi', 'Baru')
            ->first();

        if ($disposisi) {
            $disposisi->update(['status_disposisi' => 'Diterima']);
        }

        return view('surat_masuk.print', compact('suratMasuk'));
    }

    public function updateStatus(Request $request, SuratMasuk $suratMasuk)
    {
        $user = Auth::user();

        if (!$user->isSekretaris()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk memproses surat masuk ini.'
            ], 403);
        }

        $validated = $request->validate([
            'action' => ['required', Rule::in(['verifikasi', 'kembalikan', 'teruskan_ke_pimpinan'])],
            'alasan_kembali' => 'required_if:action,kembalikan|string|max:500',
            'pimpinan_tujuan_id' => 'nullable|required_if:action,teruskan_ke_pimpinan|exists:users,id',
        ]);

        switch ($validated['action']) {
            case 'verifikasi':
                if (!in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak'])) {
                    return response()->json(['success' => false, 'message' => 'Surat tidak dapat diverifikasi pada status ini.'], 400);
                }
                $suratMasuk->update(['status_surat' => 'Diverifikasi']);
                return response()->json(['success' => true, 'message' => 'Surat berhasil diverifikasi.']);

            case 'kembalikan':
                if (!in_array($suratMasuk->status_surat, ['Diajukan', 'Diverifikasi'])) {
                    return response()->json(['success' => false, 'message' => 'Surat tidak dapat dikembalikan pada status ini.'], 400);
                }
                $suratMasuk->update([
                    'status_surat' => 'Ditolak',
                    'keterangan' => $validated['alasan_kembali'],
                ]);
                return response()->json(['success' => true, 'message' => 'Surat berhasil dikembalikan.']);

            case 'teruskan_ke_pimpinan':
                if ($suratMasuk->status_surat !== 'Diverifikasi') {
                    return response()->json(['success' => false, 'message' => 'Surat hanya bisa diteruskan jika sudah diverifikasi.'], 400);
                }
                if (Disposisi::where('surat_masuk_id', $suratMasuk->id)->exists()) {
                    return response()->json(['success' => false, 'message' => 'Surat sudah diteruskan sebelumnya.'], 400);
                }
                $pimpinanTujuan = User::find($validated['pimpinan_tujuan_id']);
                if (!$pimpinanTujuan || !($pimpinanTujuan->isPimpinan() || $pimpinanTujuan->isKepalaLembaga() || $pimpinanTujuan->isKepalaBidang())) {
                    return response()->json(['success' => false, 'message' => 'Pimpinan tujuan tidak valid.'], 422);
                }
                $suratMasuk->update(['status_surat' => 'Diproses']);
                return response()->json(['success' => true, 'message' => 'Surat berhasil diteruskan ke pimpinan.']);
        }

        return response()->json(['success' => false, 'message' => 'Aksi tidak dikenali.'], 400);
    }

    /**
     * Helper method untuk otorisasi aksi.
     */
    private function authorizeAction($user, $action, $suratMasuk = null)
    {
        // Admin memiliki akses penuh
        if ($user->isAdmin()) {
            return;
        }

        switch ($action) {
            case 'create':
            case 'store':
                if (!$user->isOperator()) {
                    abort(403, "Anda tidak memiliki izin untuk $action surat masuk.");
                }
                if (!$user->jurusan_id) {
                    abort(403, "Operator harus terdaftar di jurusan untuk $action surat masuk.");
                }
                break;

            case 'show':
                // Admin, Sekretaris, Pimpinan, Kepala Lembaga, Kepala Bidang bisa melihat semua surat
                if ($user->isSekretaris() || $user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
                    return;
                }
                // Operator hanya bisa melihat surat yang dia buat
                if ($user->isOperator() && $suratMasuk && $suratMasuk->user_id === $user->id) {
                    return;
                }
                abort(403, "Anda tidak memiliki izin untuk melihat surat masuk ini.");
                break;

            case 'edit':
            case 'update':
                // Admin bisa edit semua surat
                if ($user->isAdmin()) {
                    return;
                }
                // Operator hanya bisa edit surat yang dia buat dengan status tertentu
                if ($user->isOperator() && $suratMasuk) {
                    $isOwner = $suratMasuk->user_id === $user->id;
                    $allowedStatus = in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak']);
                    if ($isOwner && $allowedStatus) {
                        return;
                    }
                }
                abort(403, "Anda tidak memiliki izin untuk mengedit surat masuk ini.");
                break;

            case 'delete':
                // Admin bisa hapus semua surat
                if ($user->isAdmin()) {
                    return;
                }
                // Operator hanya bisa hapus surat yang dia buat dengan status tertentu
                if ($user->isOperator() && $suratMasuk) {
                    $isOwner = $suratMasuk->user_id === $user->id;
                    $allowedStatus = in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak']);
                    if ($isOwner && $allowedStatus) {
                        return;
                    }
                }
                abort(403, "Anda tidak memiliki izin untuk menghapus surat masuk ini.");
                break;

            default:
                abort(403, "Aksi tidak diizinkan: $action.");
        }
    }

    /**
     * Helper method untuk validasi data surat masuk.
     */
    private function validateSuratMasuk(Request $request, $isStore = true)
    {
        // Logika validasi tidak diubah
        $fileRule = $isStore ? 'required' : 'nullable';
        $rules = [
            'nomor_agenda' => 'required|string|max:100|unique:surat_masuks,nomor_agenda' . ($isStore ? '' : ',' . $request->route('surat_masuk')->id),
            'nomor_surat_pengirim' => 'required|string|max:100',
            'tanggal_surat_pengirim' => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_surat' => "$fileRule|file|mimes:pdf,doc,docx,xls,xlsx|max:10240",
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ];
        if (!$isStore) {
            $rules['status_surat'] = ['nullable', Rule::in(['Diajukan', 'Diproses', 'Ditolak', 'Disetujui', 'Terkirim', 'Baru', 'Dibaca', 'Selesai', 'Diarsipkan'])];
            $rules['sifat_surat'] = ['nullable', Rule::in(['Sangat Penting', 'Penting', 'Biasa'])];
        } else {
            $rules['sifat_surat'] = ['required', Rule::in(['Sangat Penting', 'Penting', 'Biasa'])];
        }
        $messages = [
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
            'status_surat.in' => 'Status surat tidak valid.',
            'sifat_surat.in' => 'Sifat surat tidak valid.',
        ];
        return $request->validate($rules, $messages);
    }

    /**
     * Helper method untuk menangani upload file surat masuk.
     */
    private function handleFileUpload(Request $request, array &$validated)
    {
        // Logika upload tidak diubah
        $file = $request->file('file_surat');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $pathTarget = public_path('surat_masuk_uploads');
        if (!File::isDirectory($pathTarget)) {
            File::makeDirectory($pathTarget, 0777, true, true);
        }
        $file->move($pathTarget, $namaFile);
        $validated['file_surat_path'] = 'surat_masuk_uploads/' . $namaFile;
        $validated['nama_file_surat_asli'] = $file->getClientOriginalName();
    }
}
