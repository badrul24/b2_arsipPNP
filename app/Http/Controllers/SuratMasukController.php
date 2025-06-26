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

        $query = SuratMasuk::with(['jurusan', 'user']);

        if (! ($user->isAdmin())) {
            $query->where(function ($q) use ($user) {
                if ($user->isOperator() && $user->jurusan_id) {
                    $q->where('user_id', $user->id)
                        ->where('jurusan_id', $user->jurusan_id)
                        ->whereIn('status_surat', ['Diajukan', 'Ditolak']);
                }
                // Sekretaris: Melihat semua surat yang relevan dengan alurnya
                if ($user->isSekretaris()) {
                    $q->orWhereIn('status_surat', ['Diajukan', 'Diverifikasi', 'Ditolak', 'Diproses', 'Disetujui', 'Terkirim', 'Baru', 'Dibaca', 'Selesai', 'Diarsipkan']);
                }
                if ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
                    $q->orWhereIn('status_surat', ['Diproses', 'Disetujui', 'Terkirim', 'Baru', 'Dibaca', 'Selesai', 'Diarsipkan']);
                }
            });
        }

        $query->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                    ->orWhere('nomor_surat_pengirim', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        });

        $suratMasuks = $query->latest()->paginate(10)->withQueryString();

        // Ambil daftar pimpinan untuk diteruskan ke view (untuk aksi 'Teruskan')
        $pimpinanUsers = User::whereIn('role', ['pimpinan', 'kepala_lembaga', 'kepala_bidang'])->get(['id', 'name']);

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

    /**
     * Metode untuk Sekretaris memproses surat masuk (verifikasi/teruskan/kembalikan).
     */
    public function proses(Request $request, SuratMasuk $suratMasuk)
    {

        $user = Auth::user();
        // Otorisasi: Hanya Sekretaris yang bisa melakukan proses ini
        if (! $user->isSekretaris()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk memproses surat masuk ini.'], 403);
        }
        // Sekretaris bisa memproses jika statusnya 'Diajukan' atau 'Ditolak'
        if (! in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak','Diverifikasi'])) {
            return response()->json(['success' => false, 'message' => 'Surat ini tidak dalam status yang bisa diproses oleh Sekretaris.'], 400);
        }

        $validated = $request->validate([
            'action' => ['required', Rule::in(['verifikasi', 'kembalikan', 'teruskan_ke_pimpinan'])],
            'alasan_kembali' => 'nullable|string|max:500',
            'pimpinan_tujuan_id' => 'nullable|required_if:action,teruskan_ke_pimpinan|exists:users,id',
        ]);

        switch ($validated['action']) {
            case 'verifikasi':
                try {
                    $suratMasuk->update(['status_surat' => 'Diverifikasi']);
                    return response()->json(['success' => true, 'message' => 'Surat Masuk berhasil diverifikasi.']);
                } catch (\Exception $e) {
                    // Tangkap exception dan kembalikan sebagai response JSON yang informatif
                    return response()->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan saat verifikasi.',
                        'error' => $e->getMessage() // Kirim pesan error asli untuk debugging
                    ], 500);
                }

            case 'kembalikan':
                $suratMasuk->update([
                    'status_surat' => 'Ditolak',
                    'keterangan' => $validated['alasan_kembali'],
                ]);

                return response()->json(['success' => true, 'message' => 'Surat Masuk berhasil dikembalikan.']);

            case 'teruskan_ke_pimpinan':
                $pimpinanTujuan = User::find($validated['pimpinan_tujuan_id']);
                if (! $pimpinanTujuan || ! ($pimpinanTujuan->isPimpinan() || $pimpinanTujuan->isKepalaLembaga() || $pimpinanTujuan->isKepalaBidang())) {
                    return response()->json(['success' => false, 'message' => 'Pimpinan tujuan tidak valid.'], 422);
                }

                $suratMasuk->update(['status_surat' => 'Diproses']); // Status saat Sekretaris meneruskan ke Pimpinan

                Disposisi::create([
                    'surat_masuk_id' => $suratMasuk->id,
                    'user_pemberi_id' => $pimpinanTujuan->id,
                    'tanggal_disposisi' => now(),
                    'status_disposisi' => 'Baru',
                    'isi_disposisi' => '',
                    'catatan' => '',
                ]);

                return response()->json(['success' => true, 'message' => 'Surat Masuk berhasil diteruskan ke Pimpinan.']);
        }

        return response()->json(['success' => false, 'message' => 'Aksi tidak dikenal.'], 400);
    }

    /**
     * Helper method untuk otorisasi aksi.
     */
    private function authorizeAction($user, $action, $suratMasuk = null)
    {

        if ($user->isAdmin()) {
            return;
        }

        switch ($action) {
            case 'create':
            case 'store':
                if (! $user->isOperator()) {
                    abort(403, "Anda tidak memiliki izin untuk $action surat masuk.");
                }
                if (! $user->jurusan_id) {
                    abort(403, "Operator harus terdaftar di jurusan untuk $action surat masuk.");
                }
                break;

            case 'show':
                if (! $suratMasuk) {
                    abort(403, "Akses tidak valid: $action memerlukan surat masuk.");
                }
                // Operator/Pimpinan melihat yang jurusannya sama
                if (($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id === $suratMasuk->jurusan_id) {
                    return;
                }

                // Sekretaris melihat yang relevan dengan alurnya
                if ($user->isSekretaris() && in_array($suratMasuk->status_surat, ['Diajukan', 'Diverifikasi', 'Ditolak', 'Diproses', 'Disetujui', 'Terkirim', 'Baru', 'Dibaca', 'Selesai', 'Diarsipkan'])) {
                    return;
                }

                // Pimpinan (termasuk Kepala Lembaga/Kepala Bidang) melihat yang relevan dengan alurnya
                if (($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) && in_array($suratMasuk->status_surat, ['Diproses', 'Disetujui', 'Terkirim', 'Baru', 'Dibaca', 'Selesai', 'Diarsipkan'])) {
                    return;
                }

                abort(403, "Anda tidak memiliki izin untuk $action surat masuk ini.");
                break;

            case 'edit':
            case 'update':
                if (! $suratMasuk) {
                    abort(403, "Akses tidak valid: $action memerlukan surat masuk.");
                }
                // Operator bisa edit jika mereka yang membuat DAN status memungkinkan
                if ($user->isOperator()) {
                    if ($user->id === $suratMasuk->user_id && in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak'])) {
                        if (! $user->jurusan_id || $user->jurusan_id !== $suratMasuk->jurusan_id) {
                            abort(403, "Anda tidak memiliki izin (jurusan) untuk $action surat masuk ini.");
                        }

                        return;
                    }
                }
                // Sekretaris bisa edit jika status memungkinkan
                if ($user->isSekretaris() && in_array($suratMasuk->status_surat, ['Diverifikasi', 'Diproses'])) {
                    return;
                }
                abort(403, "Anda tidak memiliki izin untuk $action surat masuk ini.");
                break;

            case 'delete':
                if (! $suratMasuk) {
                    abort(403, "Akses tidak valid: $action memerlukan surat masuk.");
                }
                // Hanya Operator yang bisa menghapus DAN status memungkinkan
                if ($user->isOperator()) {
                    if ($user->id === $suratMasuk->user_id && in_array($suratMasuk->status_surat, ['Diajukan', 'Ditolak'])) {
                        if (! $user->jurusan_id || $user->jurusan_id !== $suratMasuk->jurusan_id) {
                            abort(403, "Anda tidak memiliki izin (jurusan) untuk $action surat masuk ini.");
                        }

                        return;
                    }
                }
                abort(403, "Anda tidak memiliki izin untuk $action surat masuk ini.");
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
        $fileRule = $isStore ? 'required' : 'nullable';

        $rules = [
            'nomor_agenda' => 'required|string|max:100|unique:surat_masuks,nomor_agenda'.($isStore ? '' : ','.$request->route('surat_masuk')->id),
            'nomor_surat_pengirim' => 'required|string|max:100',
            'tanggal_surat_pengirim' => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_surat' => "$fileRule|file|mimes:pdf,doc,docx,xls,xlsx|max:10240",
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ];

        // Validasi untuk status_surat dan sifat_surat hanya jika bukan dari form create/edit biasa
        // Ini memastikan mereka divalidasi ketika diatur melalui aksi 'proses'
        if (! $isStore) {
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
        $file = $request->file('file_surat');
        $namaFile = time().'_'.$file->getClientOriginalName();
        $pathTarget = public_path('surat_masuk_uploads');

        if (! File::isDirectory($pathTarget)) {
            File::makeDirectory($pathTarget, 0777, true, true);
        }

        $file->move($pathTarget, $namaFile);

        $validated['file_surat_path'] = 'surat_masuk_uploads/'.$namaFile;
        $validated['nama_file_surat_asli'] = $file->getClientOriginalName();
    }
}
