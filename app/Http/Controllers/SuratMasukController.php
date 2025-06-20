<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $suratMasuks = SuratMasuk::with(['jurusan', 'user'])
            ->when(($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id, function ($query) use ($user) {
                $query->where('jurusan_id', $user->jurusan_id);
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_agenda', 'like', "%{$search}%")
                      ->orWhere('nomor_surat_pengirim', 'like', "%{$search}%")
                      ->orWhere('perihal', 'like', "%{$search}%")
                      ->orWhere('keterangan', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('surat_masuk.index', compact('suratMasuks'));
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

        return view('surat_masuk.create', compact('jurusans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'store');

        $validated = $this->validateSuratMasuk($request);

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
        //
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

        return view('surat_masuk.edit', compact('suratMasuk', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'update', $suratMasuk);

        $validated = $this->validateSuratMasuk($request, false);

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

    private function authorizeAction($user, $action, $suratMasuk = null)
    {
        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, "Anda tidak memiliki izin untuk $action surat masuk.");
        }

        if ($user->isOperator()) {
            if (!$user->jurusan_id) {
                abort(403, "Operator harus terdaftar di jurusan untuk $action surat masuk.");
            }

            if ($suratMasuk && $user->jurusan_id !== $suratMasuk->jurusan_id) {
                abort(403, "Anda tidak memiliki izin untuk $action surat masuk ini.");
            }
        }
    }

    private function validateSuratMasuk(Request $request, $isStore = true)
    {
        $fileRule = $isStore ? 'required' : 'nullable';

        return $request->validate([
            'nomor_agenda' => 'required|string|max:100|unique:surat_masuks,nomor_agenda' . ($isStore ? '' : ',' . $request->route('surat_masuk')->id),
            'nomor_surat_pengirim' => 'required|string|max:100',
            'tanggal_surat_pengirim' => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_surat' => "$fileRule|file|mimes:pdf,doc,docx,xls,xlsx|max:10240",
            'jurusan_id' => 'required|exists:jurusans,id',
            'status_surat' => ['required', Rule::in(['Baru', 'Dibaca', 'Dikonfirmasi', 'Didisposisi', 'Selesai', 'Diarsipkan'])],
            'sifat_surat' => ['required', Rule::in(['Sangat Penting', 'Penting', 'Biasa'])],
        ]);
    }

    private function handleFileUpload(Request $request, array &$validated)
    {
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
