<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Divisi;
use App\Models\Jurusan;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DisposisiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Disposisi::with([
            'suratMasuk', 'userPemberi', 'userPenerima', 'divisiPenerima', 'jurusanPenerima', 'parentDisposisi',
        ]);

        if (! $user->isAdmin()) {
            $query->where(function ($q) use ($user) {
                $q->where('user_pemberi_id', $user->id)
                    ->orWhere('user_penerima_id', $user->id);

                if ($user->divisi_id) {
                    $q->orWhere('divisi_penerima_id', $user->divisi_id);
                }
                if ($user->jurusan_id) {
                    $q->orWhere('jurusan_penerima_id', $user->jurusan_id);
                }
            });
        }

        $query->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('isi_disposisi', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%")
                    ->orWhere('instruksi_kepada', 'like', "%{$search}%")
                    ->orWhere('petunjuk_disposisi', 'like', "%{$search}%")
                    ->orWhereHas('suratMasuk', function ($q_sm) use ($search) {
                        $q_sm->where('nomor_surat_pengirim', 'like', "%{$search}%")
                            ->orWhere('perihal', 'like', "%{$search}%");
                    });
            });
        });

        $disposisis = $query->latest()->paginate(10)->withQueryString();

        return view('disposisi.index', compact('disposisis'));
    }

    public function create()
    {
        $user = Auth::user();
        abort_unless($user->isPimpinan(), 403, 'Anda tidak memiliki izin untuk membuat disposisi.');

        $suratMasuks = SuratMasuk::all();
        $users = User::all();
        $divisis = Divisi::all();
        $jurusans = Jurusan::all();

        $selectedSuratMasuk = request('surat_masuk_id') ? SuratMasuk::find(request('surat_masuk_id')) : null;
        $parentDisposisis = $selectedSuratMasuk
            ? Disposisi::where('surat_masuk_id', $selectedSuratMasuk->id)->get()
            : collect();

        return view('disposisi.create', compact('suratMasuks', 'users', 'divisis', 'jurusans', 'parentDisposisis', 'selectedSuratMasuk'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        abort_unless($user->isPimpinan(), 403, 'Anda tidak memiliki izin untuk menyimpan disposisi.');

        $validated = $this->validateRequest($request);

        if (empty($validated['user_penerima_id']) && empty($validated['divisi_penerima_id']) && empty($validated['jurusan_penerima_id'])) {
            return back()->withInput()->withErrors(['penerima' => 'Minimal satu penerima (User, Divisi, atau Jurusan) harus dipilih.']);
        }

        $validated['user_pemberi_id'] = $user->id;
        $validated['instruksi_kepada'] = json_encode($validated['instruksi_kepada'] ?? []);
        $validated['petunjuk_disposisi'] = json_encode($validated['petunjuk_disposisi'] ?? []);

        $disposisi = Disposisi::create($validated);

        SuratMasuk::where('id', $validated['surat_masuk_id'])->update(['status_surat' => 'Disetujui']);

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil dibuat.');
    }

    public function show(Disposisi $disposisi)
    {
        $user = Auth::user();
        $authorized = $user->isAdmin() ||
                      $disposisi->user_pemberi_id === $user->id ||
                      $disposisi->user_penerima_id === $user->id ||
                      ($disposisi->divisi_penerima_id && $user->divisi_id === $disposisi->divisi_penerima_id) ||
                      ($disposisi->jurusan_penerima_id && $user->jurusan_id === $disposisi->jurusan_penerima_id);

        abort_unless($authorized, 403, 'Anda tidak memiliki izin untuk melihat disposisi ini.');

        return view('disposisi.show', compact('disposisi'));
    }

    public function edit(Disposisi $disposisi)
    {
        $user = Auth::user();
        abort_unless($user->isAdmin() || $disposisi->user_pemberi_id === $user->id, 403, 'Anda tidak memiliki izin untuk mengedit disposisi ini.');

        $suratMasuks = SuratMasuk::all();
        $users = User::all();
        $divisis = Divisi::all();
        $jurusans = Jurusan::all();
        $parentDisposisis = Disposisi::where('surat_masuk_id', $disposisi->surat_masuk_id)
            ->where('id', '!=', $disposisi->id)->get();

        return view('disposisi.edit', compact('disposisi', 'suratMasuks', 'users', 'divisis', 'jurusans', 'parentDisposisis'));
    }

    public function update(Request $request, Disposisi $disposisi)
    {
        $user = Auth::user();
        abort_unless($user->isAdmin() || $disposisi->user_pemberi_id === $user->id, 403, 'Anda tidak memiliki izin untuk memperbarui disposisi ini.');

        $validated = $this->validateRequest($request);

        if (empty($validated['user_penerima_id']) && empty($validated['divisi_penerima_id']) && empty($validated['jurusan_penerima_id'])) {
            return back()->withInput()->withErrors(['penerima' => 'Minimal satu penerima (User, Divisi, atau Jurusan) harus dipilih.']);
        }

        $validated['instruksi_kepada'] = json_encode($validated['instruksi_kepada'] ?? []);
        $validated['petunjuk_disposisi'] = json_encode($validated['petunjuk_disposisi'] ?? []);

        $disposisi->update($validated);

        if ($disposisi->suratMasuk && $disposisi->suratMasuk->status_surat === 'Diproses') {
            $disposisi->suratMasuk->update(['status_surat' => 'Disetujui']);
        }

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil diperbarui.');
    }

    public function destroy(Disposisi $disposisi)
    {
        $user = Auth::user();
        abort_unless($user->isAdmin() || $disposisi->user_pemberi_id === $user->id, 403, 'Anda tidak memiliki izin untuk menghapus disposisi ini.');

        $disposisi->delete();

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil dihapus.');
    }

    public function updateStatus(Request $request, Disposisi $disposisi)
    {
        $user = Auth::user();
        $allowed = $user->isAdmin() ||
                   $disposisi->user_penerima_id === $user->id ||
                   ($disposisi->divisi_penerima_id && $user->divisi_id === $disposisi->divisi_penerima_id) ||
                   ($disposisi->jurusan_penerima_id && $user->jurusan_id === $disposisi->jurusan_penerima_id);

        if (! $allowed) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk memperbarui status disposisi ini.'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['Diterima', 'Dikerjakan', 'Selesai', 'Ditolak', 'Dibaca', 'Terkirim'])],
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
        ]);

        $disposisi->update(['status_disposisi' => $validated['status']]);

        $suratMasuk = SuratMasuk::find($validated['surat_masuk_id']);
        if ($suratMasuk) {
            $statusMap = [
                'Diterima' => 'Baru',
                'Dibaca' => 'Dibaca',
                'Selesai' => 'Selesai',
            ];
            if (isset($statusMap[$validated['status']])) {
                $suratMasuk->update(['status_surat' => $statusMap[$validated['status']]]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status disposisi berhasil diperbarui menjadi '.$validated['status'].'.',
        ], 200);
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
            'user_penerima_id' => 'nullable|exists:users,id',
            'divisi_penerima_id' => 'nullable|exists:divisis,id',
            'jurusan_penerima_id' => 'nullable|exists:jurusans,id',
            'instruksi_kepada' => 'nullable|array',
            'petunjuk_disposisi' => 'nullable|array',
            'isi_disposisi' => 'required|string',
            'catatan' => 'nullable|string',
            'tanggal_disposisi' => 'required|date',
            'status_disposisi' => ['required', Rule::in(['Baru', 'Diterima', 'Dikerjakan', 'Selesai', 'Ditolak', 'Diteruskan'])],
            'parent_disposisi_id' => 'nullable|exists:disposisis,id',
        ], [
            'user_penerima_id.exists' => 'Penerima user tidak valid.',
            'divisi_penerima_id.exists' => 'Penerima divisi tidak valid.',
            'jurusan_penerima_id.exists' => 'Penerima jurusan tidak valid.',
            'instruksi_kepada.array' => 'Format instruksi disposisi kepada tidak valid.',
            'petunjuk_disposisi.array' => 'Format petunjuk disposisi tidak valid.',
            'status_disposisi.in' => 'Status disposisi tidak valid.',
            'parent_disposisi_id.exists' => 'Disposisi induk tidak valid.',
        ]);
    }
}
