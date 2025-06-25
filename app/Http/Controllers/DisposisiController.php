<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use App\Models\Divisi;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Disposisi::with([
            'suratMasuk', 'userPemberi', 'userPenerima', 'divisiPenerima', 'jurusanPenerima', 'parentDisposisi'
        ]);

        if (!($user->isAdmin())) {
            $query->where(function($q) use ($user) {
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
            $query->where(function($q) use ($search) {
                $q->where('isi_disposisi', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%")
                  ->orWhere('instruksi_kepada', 'like', "%{$search}%")
                  ->orWhere('petunjuk_disposisi', 'like', "%{$search}%")
                  ->orWhereHas('suratMasuk', function($q_sm) use ($search) {
                      $q_sm->where('nomor_surat_pengirim', 'like', "%{$search}%")
                           ->orWhere('perihal', 'like', "%{$search}%");
                  });
            });
        });

        $disposisis = $query->latest()->paginate(10)->withQueryString();
        return view('disposisi.index', compact('disposisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!($user->isPimpinan())) { // Hanya Pimpinan yang bisa membuat disposisi
             abort(403, 'Anda tidak memiliki izin untuk membuat disposisi.');
        }

        $suratMasuks = SuratMasuk::all();
        $users = User::all();
        $divisis = Divisi::all();
        $jurusans = Jurusan::all();
        
        $parentDisposisis = collect();
        $selectedSuratMasuk = null;
        if (request('surat_masuk_id')) {
            $selectedSuratMasuk = SuratMasuk::find(request('surat_masuk_id'));
            if ($selectedSuratMasuk) {
                $parentDisposisis = Disposisi::where('surat_masuk_id', $selectedSuratMasuk->id)->get();
            }
        }
        
        return view('disposisi.create', compact('suratMasuks', 'users', 'divisis', 'jurusans', 'parentDisposisis', 'selectedSuratMasuk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!($user->isPimpinan())) { // Hanya Pimpinan yang bisa menyimpan disposisi
             abort(403, 'Anda tidak memiliki izin untuk menyimpan disposisi.');
        }

        $validated = $request->validate([
            'surat_masuk_id'    => 'required|exists:surat_masuks,id',
            'user_penerima_id'  => 'nullable|exists:users,id',
            'divisi_penerima_id'=> 'nullable|exists:divisis,id',
            'jurusan_penerima_id'=> 'nullable|exists:jurusans,id',
            // Validasi untuk kolom multi-select
            'instruksi_kepada'  => 'nullable|array',
            'petunjuk_disposisi'=> 'nullable|array',
            'isi_disposisi'     => 'required|string',
            'catatan'           => 'nullable|string',
            'tanggal_disposisi' => 'required|date',
            'status_disposisi'  => ['required', Rule::in(['Baru', 'Diterima', 'Dikerjakan', 'Selesai', 'Ditolak', 'Diteruskan'])],
            'parent_disposisi_id'=> 'nullable|exists:disposisis,id',
        ], [
            'user_penerima_id.exists' => 'Penerima user tidak valid.',
            'divisi_penerima_id.exists' => 'Penerima divisi tidak valid.',
            'jurusan_penerima_id.exists' => 'Penerima jurusan tidak valid.',
            'instruksi_kepada.array' => 'Format instruksi disposisi kepada tidak valid.',
            'petunjuk_disposisi.array' => 'Format petunjuk disposisi tidak valid.',
            'status_disposisi.in' => 'Status disposisi tidak valid.',
            'parent_disposisi_id.exists' => 'Disposisi induk tidak valid.',
        ]);

        if (empty($validated['user_penerima_id']) && empty($validated['divisi_penerima_id']) && empty($validated['jurusan_penerima_id'])) {
            return back()->withInput()->withErrors(['penerima' => 'Minimal satu penerima (User, Divisi, atau Jurusan) harus dipilih.']);
        }
        
        $validated['instruksi_kepada'] = json_encode($validated['instruksi_kepada'] ?? []);
        $validated['petunjuk_disposisi'] = json_encode($validated['petunjuk_disposisi'] ?? []);

        $validated['user_pemberi_id'] = $user->id;
        
        $disposisi = Disposisi::create($validated);

        $suratMasuk = SuratMasuk::find($validated['surat_masuk_id']);
        if ($suratMasuk) {
            $suratMasuk->update(['status_surat' => 'Disetujui']);
        }

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposisi $disposisi)
    {
        $user = Auth::user();
        if (!($user->isAdmin() ||
              $disposisi->user_pemberi_id === $user->id ||
              $disposisi->user_penerima_id === $user->id ||
              ($disposisi->divisi_penerima_id && $user->divisi_id === $disposisi->divisi_penerima_id) ||
              ($disposisi->jurusan_penerima_id && $user->jurusan_id === $disposisi->jurusan_penerima_id)
            )) {
            abort(403, 'Anda tidak memiliki izin untuk melihat disposisi ini.');
        }

        return view('disposisi.show', compact('disposisi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposisi $disposisi)
    {
        $user = Auth::user();
        // Otorisasi: Hanya Admin atau user pemberi yang bisa mengedit disposisi.
        if (!($user->isAdmin() || $disposisi->user_pemberi_id === $user->id)) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit disposisi ini.');
        }

        $suratMasuks = SuratMasuk::all();
        $users = User::all();
        $divisis = Divisi::all();
        $jurusans = Jurusan::all();

        $parentDisposisis = Disposisi::where('surat_masuk_id', $disposisi->surat_masuk_id)
                                    ->where('id', '!=', $disposisi->id)
                                    ->get();

        return view('disposisi.edit', compact(
            'disposisi', 'suratMasuks', 'users', 'divisis', 'jurusans', 'parentDisposisis'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposisi $disposisi)
    {
        $user = Auth::user();
        // Otorisasi (sama seperti di edit)
        if (!($user->isAdmin() || $disposisi->user_pemberi_id === $user->id)) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui disposisi ini.');
        }

        $validated = $request->validate([
            'surat_masuk_id'    => 'required|exists:surat_masuks,id',
            'user_penerima_id'  => 'nullable|exists:users,id',
            'divisi_penerima_id'=> 'nullable|exists:divisis,id',
            'jurusan_penerima_id'=> 'nullable|exists:jurusans,id',
            // Validasi untuk kolom multi-select
            'instruksi_kepada'  => 'nullable|array',
            'petunjuk_disposisi'=> 'nullable|array',
            'isi_disposisi'     => 'required|string',
            'catatan'           => 'nullable|string',
            'tanggal_disposisi' => 'required|date',
            'status_disposisi'  => ['required', Rule::in(['Baru', 'Diterima', 'Dikerjakan', 'Selesai', 'Ditolak', 'Diteruskan'])],
            'parent_disposisi_id'=> 'nullable|exists:disposisis,id',
        ], [
            'user_penerima_id.exists' => 'Penerima user tidak valid.',
            'divisi_penerima_id.exists' => 'Penerima divisi tidak valid.',
            'jurusan_penerima_id.exists' => 'Penerima jurusan tidak valid.',
            'instruksi_kepada.array' => 'Format instruksi disposisi kepada tidak valid.',
            'petunjuk_disposisi.array' => 'Format petunjuk disposisi tidak valid.',
            'status_disposisi.in' => 'Status disposisi tidak valid.',
            'parent_disposisi_id.exists' => 'Disposisi induk tidak valid.'
        ]);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposisi $disposisi)
    {
        $user = Auth::user();
        if (!($user->isAdmin() || $disposisi->user_pemberi_id === $user->id)) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus disposisi ini.');
        }

        $disposisi->delete();
        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil dihapus.');
    }

    /**
     * Metode untuk mengupdate status disposisi (oleh penerima disposisi).
     * Dipanggil via AJAX/fetch.
     */
    public function updateStatus(Request $request, Disposisi $disposisi)
    {
        $user = Auth::user();
        if (!($user->isAdmin() ||
              $disposisi->user_penerima_id === $user->id ||
              ($disposisi->divisi_penerima_id && $user->divisi_id === $disposisi->divisi_penerima_id) ||
              ($disposisi->jurusan_penerima_id && $user->jurusan_id === $disposisi->jurusan_penerima_id)
            )) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin untuk memperbarui status disposisi ini.'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['Diterima', 'Dikerjakan', 'Selesai', 'Ditolak', 'Dibaca', 'Terkirim'])], // Perluas Rule::in jika status baru seperti 'Dibaca', 'Terkirim' juga diatur di sini
            'surat_masuk_id' => 'required|exists:surat_masuks,id', // Diperlukan untuk update status surat masuk
        ]);

        $disposisi->update(['status_disposisi' => $validated['status']]);

        $suratMasuk = SuratMasuk::find($validated['surat_masuk_id']);
        if ($suratMasuk) {
            switch ($validated['status']) {
                case 'Diterima':
                    $suratMasuk->update(['status_surat' => 'Baru']); // Disposisi diterima penerima
                    break;
                case 'Dibaca':
                    $suratMasuk->update(['status_surat' => 'Dibaca']); // Disposisi dicetak/dibaca oleh penerima
                    break;
                case 'Selesai':
                    $suratMasuk->update(['status_surat' => 'Selesai']); // Disposisi selesai dikerjakan
                    break;
                case 'Ditolak':
                    break;
                case 'Diteruskan':
                    break;
            }
        }

        return response()->json(['success' => true, 'message' => 'Status disposisi berhasil diperbarui menjadi ' . $validated['status'] . '.'], 200);
    }
}
