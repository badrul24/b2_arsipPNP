<?php

namespace App\Http\Controllers;

use App\Models\{Disposisi, Divisi, SuratMasuk, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DisposisiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Disposisi::with(['suratMasuk', 'userPemberi', 'userPenerima', 'divisiPenerima', 'parentDisposisi']);

        if ($user->isAdmin() || $user->isSekretaris()) {
            // Admin dan Sekretaris dapat melihat semua disposisi, tidak perlu filter tambahan.
        } 
        elseif ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
            // Pimpinan, Kepala Lembaga, dan Kepala Bidang melihat disposisi yang MEREKA KIRIM atau MEREKA TERIMA.
            $query->where(function ($q) use ($user) {
                $q->where('user_pemberi_id', $user->id)      // Disposisi yang mereka kirim
                  ->orWhere('user_penerima_id', $user->id); // Disposisi yang mereka terima secara personal

                // Jika user memiliki divisi, tampilkan juga disposisi yang ditujukan ke divisinya
                if ($user->divisi_id) {
                    $q->orWhere('divisi_penerima_id', $user->divisi_id);
                }
            });
        } 
        elseif ($user->isOperator()) {
            // Operator hanya melihat disposisi yang terkait dengan surat masuk yang mereka buat.
            $query->whereHas('suratMasuk', function ($q_sm) use ($user) {
                $q_sm->where('user_id', $user->id);
            });
        } 
        else {
            $query->whereRaw('1 = 0'); // Query yang tidak akan mengembalikan hasil
        }

        $query->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('isi_disposisi', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%")
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
        abort_unless($user->isPimpinan(), 403, 'Anda tidak memiliki izin.');

        $suratMasuks = SuratMasuk::latest()->get();

        $usersWithDivisions = User::whereNotNull('divisi_id')
            ->with('divisi')
            ->get(['id', 'name', 'divisi_id']);

        $divisis = Divisi::all();

        $selectedSuratMasuk = request()->filled('surat_masuk_id')
            ? SuratMasuk::find(request('surat_masuk_id'))
            : null;

        $parentDisposisis = $selectedSuratMasuk
            ? Disposisi::where('surat_masuk_id', $selectedSuratMasuk->id)->get()
            : collect();

        return view('disposisi.create', compact(
            'suratMasuks',
            'divisis',
            'parentDisposisis',
            'selectedSuratMasuk',
            'usersWithDivisions'
        ));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        abort_unless(
            $user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang() || $user->isAdmin(),
            403
        );

        $validated = $this->validateRequest($request);

        if (empty($validated['instruksi_kepada'])) {
            return back()->withInput()->withErrors(['instruksi_kepada' => 'Pilih minimal satu penerima disposisi.']);
        }

        foreach ($validated['instruksi_kepada'] as $idPenerima) {
            $penerima = User::with('divisi')->find($idPenerima);

            Disposisi::create([
                'surat_masuk_id'      => $validated['surat_masuk_id'],
                'user_pemberi_id'     => $user->id,
                'user_penerima_id'    => $idPenerima,
                'divisi_penerima_id'  => $penerima->divisi_id, // ✅ INI YANG KURANG
                'tanggal_disposisi'   => now()->format('Y-m-d'),
                'status_disposisi'    => 'Baru',
                'isi_disposisi'       => $validated['isi_disposisi'],
                'catatan'             => $validated['catatan'] ?? null,
                'petunjuk_disposisi'  => $validated['petunjuk_disposisi'] ?? null,
                'parent_disposisi_id' => $validated['parent_disposisi_id'] ?? null,
            ]);
        }

        if ($suratMasuk = SuratMasuk::find($validated['surat_masuk_id'])) {
            $suratMasuk->update(['status_surat' => 'Terkirim']);
        }

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil dibuat.');
    }


    public function show(Disposisi $disposisi)
    {
        $user = Auth::user();

        $authorized = $user->isAdmin() ||
            $user->isPimpinan() ||
            $disposisi->user_pemberi_id === $user->id ||
            $disposisi->user_penerima_id === $user->id ||
            ($disposisi->divisi_penerima_id && $user->divisi_id === $disposisi->divisi_penerima_id) ||
            ($disposisi->jurusan_penerima_id && $user->jurusan_id === $disposisi->jurusan_penerima_id);

        abort_unless($authorized, 403);

        return view('disposisi.show', compact('disposisi'));
    }

    public function edit(Disposisi $disposisi)
    {
        $user = Auth::user();
        abort_unless($user->isAdmin() || $disposisi->user_pemberi_id === $user->id, 403);

        $suratMasuks = SuratMasuk::all();
        $divisis = Divisi::all();
        $parentDisposisis = Disposisi::where('surat_masuk_id', $disposisi->surat_masuk_id)
            ->where('id', '!=', $disposisi->id)->get();
        $usersWithDivisions = User::whereNotNull('divisi_id')->with('divisi')->get(['id', 'name', 'divisi_id']);

        return view('disposisi.edit', compact(
            'disposisi',
            'parentDisposisis',
            'usersWithDivisions',
            'suratMasuks',
            'divisis'
        ));
    }

    public function update(Request $request, Disposisi $disposisi)
    {
        $user = Auth::user();
        abort_unless($user->isAdmin() || $disposisi->user_pemberi_id === $user->id, 403);

        $validated = $this->validateRequest($request);

        if (empty($validated['instruksi_kepada'])) {
            return back()->withInput()->withErrors(['instruksi_kepada' => 'Pilih minimal satu penerima disposisi.']);
        }

        $disposisi->update($validated);

        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil diperbarui.');
    }

    public function destroy(Disposisi $disposisi)
    {
        $user = Auth::user();
        abort_unless($user->isAdmin() || $disposisi->user_pemberi_id === $user->id, 403);

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

        if (!$allowed) {
            return response()->json(['success' => false, 'message' => 'Tidak punya izin.'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['Baru', 'Diterima', 'Dikerjakan', 'Selesai', 'Ditolak', 'Diteruskan'])],
            'surat_masuk_id' => 'sometimes|exists:surat_masuks,id',
        ]);

        $disposisi->update(['status_disposisi' => $validated['status']]);

        if ($request->has('surat_masuk_id')) {
            if ($suratMasuk = SuratMasuk::find($request->surat_masuk_id)) {
                if ($validated['status'] === 'Selesai') {
                    $suratMasuk->update(['status_surat' => 'Selesai']);
                } elseif ($validated['status'] === 'Diterima') {
                    $suratMasuk->update(['status_surat' => 'Terkirim']);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui.'
        ], 200);
    }

    public function terima($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        // Hanya buat catatan disposisi penerima jika status surat adalah Terkirim
        if ($suratMasuk->status_surat !== 'Terkirim') {
            return redirect()->back()->with('info', 'Surat belum dikirim. Tidak dapat mencatat penerimaan.');
        }

        $existing = Disposisi::where('surat_masuk_id', $id)
            ->where('oleh', Auth::id())
            ->where('status', 'Diterima oleh penerima')
            ->first();

        if (!$existing) {
            Disposisi::create([
                'surat_masuk_id' => $id,
                'oleh' => Auth::id(),
                'tujuan_disposisi' => Auth::user()->name,
                'catatan' => 'Surat diterima oleh penerima.',
                'status' => 'Diterima oleh penerima',
            ]);
        }

        return redirect()->back()->with('success', 'Surat ditandai telah diterima dan dicatat dalam disposisi.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
            'instruksi_kepada' => 'required|array',
            'instruksi_kepada.*' => 'string|max:255',
            'petunjuk_disposisi' => 'nullable|array',
            'petunjuk_disposisi.*' => 'string|max:255',
            'isi_disposisi' => 'required|string',
            'catatan' => 'nullable|string',
            'tanggal_disposisi' => 'nullable|date',
            'status_disposisi' => 'nullable|string|in:Baru,Diterima,Dikerjakan,Selesai,Ditolak,Diteruskan',
            'parent_disposisi_id' => 'nullable|exists:disposisis,id',
        ]);
    }
}
