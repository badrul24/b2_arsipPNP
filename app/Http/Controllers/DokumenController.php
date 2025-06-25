<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\Kode;
use App\Models\Lokasi;
use App\Models\Retensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $dokumens = Dokumen::with(['kategori', 'kode', 'lokasi', 'retensi', 'jurusan', 'user'])
            ->when(($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id, function ($query) use ($user) {
                $query->where('jurusan_id', $user->jurusan_id);
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_surat', 'like', "%{$search}%")
                        ->orWhere('judul', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'create');

        $kategoris = Kategori::all();
        $kodes = Kode::all();
        $lokasis = Lokasi::all();
        $retensis = Retensi::all();
        $jurusans = $user->isOperator() && $user->jurusan_id
            ? Jurusan::where('id', $user->jurusan_id)->get()
            : Jurusan::all();

        return view('dokumen.create', compact('kategoris', 'kodes', 'lokasis', 'retensis', 'jurusans'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'store');

        $validated = $this->validateDokumen($request);

        if ($request->hasFile('file')) {
            $this->handleFileUpload($request, $validated);
        }

        if ($user->isOperator() && $user->jurusan_id) {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        $validated['user_id'] = $user->id;
        Dokumen::create($validated);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(Dokumen $dokumen)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'edit', $dokumen);

        $kategoris = Kategori::all();
        $kodes = Kode::all();
        $lokasis = Lokasi::all();
        $retensis = Retensi::all();
        $jurusans = $user->isOperator() && $user->jurusan_id
            ? Jurusan::where('id', $user->jurusan_id)->get()
            : Jurusan::all();

        return view('dokumen.edit', compact('dokumen', 'kategoris', 'kodes', 'lokasis', 'retensis', 'jurusans'));
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'update', $dokumen);

        $validated = $this->validateDokumen($request, false);

        if ($request->hasFile('file')) {
            if ($dokumen->file_path && File::exists(public_path($dokumen->file_path))) {
                File::delete(public_path($dokumen->file_path));
            }
            $this->handleFileUpload($request, $validated);
        } else {
            $validated['file_path'] = $dokumen->file_path;
            $validated['nama_file_asli'] = $dokumen->nama_file_asli;
        }

        if ($user->isOperator() && $user->jurusan_id) {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        $dokumen->update($validated);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        $user = Auth::user();
        $this->authorizeAction($user, 'delete', $dokumen);

        if ($dokumen->file_path && File::exists(public_path($dokumen->file_path))) {
            File::delete(public_path($dokumen->file_path));
        }

        $dokumen->delete();

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    private function authorizeAction($user, $action, $dokumen = null)
    {
        if (! $user->isAdmin() && ! $user->isOperator()) {
            abort(403, "Anda tidak memiliki izin untuk $action dokumen.");
        }

        if ($user->isOperator()) {
            if (! $user->jurusan_id) {
                abort(403, "Operator harus terdaftar di jurusan untuk $action dokumen.");
            }

            if ($dokumen && $user->jurusan_id !== $dokumen->jurusan_id) {
                abort(403, "Anda tidak memiliki izin untuk $action dokumen ini.");
            }
        }
    }

    private function validateDokumen(Request $request, $isStore = true)
    {
        $fileRule = $isStore ? 'required' : 'nullable';

        return $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'judul' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'keterangan' => 'nullable|string',
            'file' => "$fileRule|file|mimes:pdf,doc,docx,xls,xlsx|max:10240",
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_id' => 'required|exists:kodes,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'retensi_id' => 'required|exists:retensis,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'sifat' => ['required', Rule::in(['Sangat Penting', 'Penting', 'Biasa'])],
            'status' => ['required', Rule::in(['Aktif', 'Inaktif', 'Musnah'])],
            'jenis' => ['required', Rule::in(['Surat', 'Laporan', 'Memorandum', 'Perjanjian', 'SK'])],
        ]);
    }

    private function handleFileUpload(Request $request, array &$validated)
    {
        $file = $request->file('file');
        $namaFile = time().'_'.$file->getClientOriginalName();
        $pathTarget = public_path('dokumen_uploads');

        if (! File::isDirectory($pathTarget)) {
            File::makeDirectory($pathTarget, 0777, true, true);
        }

        $file->move($pathTarget, $namaFile);

        $validated['file_path'] = 'dokumen_uploads/'.$namaFile;
        $validated['nama_file_asli'] = $file->getClientOriginalName();
    }
}
