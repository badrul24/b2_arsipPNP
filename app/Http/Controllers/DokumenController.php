<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\Kode;
use App\Models\Lokasi;
use App\Models\Retensi;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Dokumen::with([
            'kategori',
            'kode',
            'lokasi',
            'retensi',
            'jurusan',
            'user'
        ]);

        if (($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id) {
            $query->where('jurusan_id', $user->jurusan_id);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $dokumens = $query->latest()->paginate(10)->withQueryString();
        return view('dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk menambah dokumen.');
        }

        if ($user->isOperator() && !$user->jurusan_id) {
            abort(403, 'Operator harus terdaftar di sebuah jurusan untuk menambah dokumen.');
        }

        $kategoris = Kategori::all();
        $kodes = Kode::all();
        $lokasis = Lokasi::all();
        $retensis = Retensi::all();
        if ($user->isOperator() && $user->jurusan_id) {
            $jurusans = Jurusan::where('id', $user->jurusan_id)->get();
        } else {
            $jurusans = Jurusan::all();
        }

        return view('dokumen.create', compact(
            'kategoris',
            'kodes',
            'lokasis',
            'retensis',
            'jurusans'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk menyimpan dokumen.');
        }
        if ($user->isOperator() && !$user->jurusan_id) {
            abort(403, 'Operator harus terdaftar di sebuah jurusan untuk menyimpan dokumen.');
        }

        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'judul' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'keterangan' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_id' => 'required|exists:kodes,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'retensi_id' => 'required|exists:retensis,id',
            'jurusan_id' => 'required|exists:jurusans,id',

            'sifat'  => ['required', Rule::in(['Sangat Penting', 'Penting', 'Biasa'])],
            'status' => ['required', Rule::in(['Aktif', 'Inaktif', 'Musnah'])],
            'jenis'  => ['required', Rule::in(['Surat', 'Laporan', 'Memorandum', 'Perjanjian', 'SK'])],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $pathTarget = public_path('dokumen_uploads');

            if (!File::isDirectory($pathTarget)) {
                File::makeDirectory($pathTarget, 0777, true, true);
            }

            $file->move($pathTarget, $namaFile);

            $validated['file_path'] = 'dokumen_uploads/' . $namaFile;
            $validated['nama_file_asli'] = $file->getClientOriginalName();
        }

        if ($user->isOperator() && $user->jurusan_id) {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        $validated['user_id'] = Auth::id();

        Dokumen::create($validated);
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(Dokumen $dokumen)
    {
        // $user = Auth::user();

        // if (($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id !== $dokumen->jurusan_id) {
        //     abort(403, 'Anda tidak memiliki akses untuk melihat dokumen ini.');
        // }

        // return view('dokumen.show', compact('dokumen'));
    }

    public function edit(Dokumen $dokumen)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit dokumen.');
        }
        if ($user->isOperator() && $user->jurusan_id !== $dokumen->jurusan_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit dokumen ini.');
        }

        $kategoris = Kategori::all();
        $kodes = Kode::all();
        $lokasis = Lokasi::all();
        $retensis = Retensi::all();
        if ($user->isOperator() && $user->jurusan_id) {
            $jurusans = Jurusan::where('id', $user->jurusan_id)->get();
        } else {
            $jurusans = Jurusan::all();
        }

        return view('dokumen.edit', compact(
            'dokumen',
            'kategoris',
            'kodes',
            'lokasis',
            'retensis',
            'jurusans'
        ));
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui dokumen.');
        }
        if ($user->isOperator() && $user->jurusan_id !== $dokumen->jurusan_id) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui dokumen ini.');
        }

        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'judul' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_id' => 'required|exists:kodes,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'retensi_id' => 'required|exists:retensis,id',
            'jurusan_id' => 'required|exists:jurusans,id',

            'sifat'  => ['required', Rule::in(['Sangat Penting', 'Penting', 'Biasa'])],
            'status' => ['required', Rule::in(['Aktif', 'Inaktif', 'Musnah'])],
            'jenis'  => ['required', Rule::in(['Surat', 'Laporan', 'Memorandum', 'Perjanjian', 'SK'])],
        ]);

        if ($request->hasFile('file')) {
            if ($dokumen->file_path && File::exists(public_path($dokumen->file_path))) {
                File::delete(public_path($dokumen->file_path));
            }

            $file = $request->file('file');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $pathTarget = public_path('dokumen_uploads');

            if (!File::isDirectory($pathTarget)) {
                File::makeDirectory($pathTarget, 0777, true, true);
            }
            $file->move($pathTarget, $namaFile);
            $validated['file_path'] = 'dokumen_uploads/' . $namaFile;
            $validated['nama_file_asli'] = $file->getClientOriginalName();
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

        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus dokumen.');
        }
        if ($user->isOperator() && $user->jurusan_id !== $dokumen->jurusan_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus dokumen ini.');
        }

        if ($dokumen->file_path && File::exists(public_path($dokumen->file_path))) {
            File::delete(public_path($dokumen->file_path));
        }

        $dokumen->delete();
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}