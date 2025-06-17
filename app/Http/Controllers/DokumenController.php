<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\Kode; // Menggunakan Model Kode sesuai konfirmasi Anda
use App\Models\Lokasi; // Menggunakan Model Lokasi sesuai konfirmasi Anda
use App\Models\Retensi; // Menggunakan Model Retensi sesuai konfirmasi Anda
use App\Models\StatusDokumen;
use App\Models\SifatDokumen;
use App\Models\JenisDokumen;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Menggunakan Facade File untuk operasi file
use Illuminate\Support\Facades\Auth; // Penting untuk Auth::user()

class DokumenController extends Controller
{
    /**
     * Menampilkan daftar semua dokumen, difilter berdasarkan jurusan jika user adalah operator/pimpinan.
     */
    public function index(Request $request)
    {
        $user = Auth::user(); // Ambil user yang sedang login

        // Eager load relasi untuk mengurangi query ke database.
        // Pastikan nama relasi di model Dokumen (misal: 'kode()', 'lokasi()') sudah sesuai.
        $query = Dokumen::with([
            'kategori', 'kode', 'lokasi', 'retensi', 'statusDokumen',
            'sifatDokumen', 'jenisDokumen', 'jurusan', 'user'
        ]);

        // Implementasi Hak Akses: Filter Dokumen berdasarkan Jurusan
        // Jika user adalah Operator atau Pimpinan dan memiliki jurusan_id,
        // hanya tampilkan dokumen dari jurusan mereka. Admin melihat semua dokumen.
        if (($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id) {
            $query->where('jurusan_id', $user->jurusan_id);
        }

        // Fitur Pencarian berdasarkan nomor_surat, judul, atau keterangan.
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        // Urutkan berdasarkan yang terbaru dan paginasi hasilnya.
        $dokumens = $query->latest()->paginate(10)->withQueryString();
        return view('dokumen.index', compact('dokumens'));
    }

    /**
     * Menampilkan form untuk membuat dokumen baru.
     */
    public function create()
    {
        $user = Auth::user();

        // Hak Akses: Hanya Admin dan Operator yang boleh mengakses form pembuatan dokumen.
        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk menambah dokumen.');
        }

        // Jika user adalah Operator, pastikan mereka terdaftar di sebuah jurusan.
        if ($user->isOperator() && !$user->jurusan_id) {
            abort(403, 'Operator harus terdaftar di sebuah jurusan untuk menambah dokumen.');
        }

        // Ambil semua data master untuk dropdown di form.
        $kategoris = Kategori::all();
        $kodes = Kode::all();
        $lokasis = Lokasi::all();
        $retensis = Retensi::all();
        $statusDokumens = StatusDokumen::all();
        $sifatDokumens = SifatDokumen::all();
        $jenisDokumens = JenisDokumen::all();
        
        // Filter Jurusan untuk Form Create:
        // Jika user adalah operator, dia hanya boleh melihat dan memilih jurusannya sendiri.
        // Jika admin, dia bisa melihat dan memilih semua jurusan.
        if ($user->isOperator() && $user->jurusan_id) {
            $jurusans = Jurusan::where('id', $user->jurusan_id)->get();
        } else {
            $jurusans = Jurusan::all();
        }

        return view('dokumen.create', compact(
            'kategoris', 'kodes', 'lokasis', 'retensis',
            'statusDokumens', 'sifatDokumens', 'jenisDokumens', 'jurusans'
        ));
    }

    /**
     * Menyimpan dokumen baru ke storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Hak Akses: Hanya Admin dan Operator yang boleh menyimpan dokumen.
        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk menyimpan dokumen.');
        }
        // Jika user adalah Operator, pastikan mereka terdaftar di sebuah jurusan.
        if ($user->isOperator() && !$user->jurusan_id) {
            abort(403, 'Operator harus terdaftar di sebuah jurusan untuk menyimpan dokumen.');
        }

        // Aturan validasi untuk data input dan file.
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'judul' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'keterangan' => 'nullable|string',
            // Aturan validasi file: wajib ada, tipe file tertentu, ukuran max 10MB.
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // PDF, Word, Excel
            'kategori_id' => 'required|exists:kategori,id',
            'kode_id' => 'required|exists:kode,id',
            'lokasi_id' => 'required|exists:lokasi,id',
            'retensi_id' => 'required|exists:retensi,id',
            'status_id' => 'required|exists:status_dokumen,id',
            'sifat_id' => 'required|exists:sifat_dokumen,id',
            'jenis_id' => 'required|exists:jenis_dokumen,id',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        // Logika upload dan penyimpanan file.
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Buat nama file unik menggunakan timestamp + nama asli file.
            $namaFile = time() . '_' . $file->getClientOriginalName();
            // Tentukan folder target di dalam direktori public.
            $pathTarget = public_path('dokumen_uploads'); 

            // Pastikan direktori target ada, jika belum, buatlah.
            if (!File::isDirectory($pathTarget)) {
                File::makeDirectory($pathTarget, 0777, true, true);
            }

            // Pindahkan file ke folder target.
            $file->move($pathTarget, $namaFile);
            
            // Simpan path relatif dari folder public ke database.
            $validated['file_path'] = 'dokumen_uploads/' . $namaFile; 
            $validated['nama_file_asli'] = $file->getClientOriginalName();
        }

        // Paksa jurusan_id sesuai user yang login jika peran adalah Operator.
        // Ini mencegah operator mengunggah dokumen ke jurusan lain secara sengaja atau tidak.
        if ($user->isOperator() && $user->jurusan_id) {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        // Secara otomatis mengisi user_id dengan ID user yang sedang login.
        $validated['user_id'] = Auth::id();

        // Buat record dokumen baru di database.
        Dokumen::create($validated);
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dokumen tertentu.
     */
    public function show(Dokumen $dokumen)
    {
        $user = Auth::user();

        // Hak Akses: Admin bisa melihat semua dokumen.
        // Operator atau Pimpinan hanya bisa melihat dokumen yang jurusannya sama dengan jurusan mereka.
        if (($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id !== $dokumen->jurusan_id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat dokumen ini.');
        }

        return view('dokumen.show', compact('dokumen'));
    }

    /**
     * Menampilkan form untuk mengedit dokumen tertentu.
     */
    public function edit(Dokumen $dokumen)
    {
        $user = Auth::user();

        // Hak Akses: Hanya Admin dan Operator yang boleh mengedit dokumen.
        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit dokumen.');
        }
        // Jika user adalah Operator, pastikan mereka hanya bisa mengedit dokumen dari jurusannya.
        if ($user->isOperator() && $user->jurusan_id !== $dokumen->jurusan_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit dokumen ini.');
        }

        // Ambil semua data master untuk dropdown di form.
        $kategoris = Kategori::all();
        $kodes = Kode::all();
        $lokasis = Lokasi::all();
        $retensis = Retensi::all();
        $statusDokumens = StatusDokumen::all();
        $sifatDokumens = SifatDokumen::all();
        $jenisDokumens = JenisDokumen::all();
        
        // Filter Jurusan untuk Form Edit:
        // Jika user adalah operator, dia hanya boleh melihat dan memilih jurusannya sendiri.
        // Jika admin, dia bisa melihat dan memilih semua jurusan.
        if ($user->isOperator() && $user->jurusan_id) {
            $jurusans = Jurusan::where('id', $user->jurusan_id)->get();
        } else {
            $jurusans = Jurusan::all();
        }

        return view('dokumen.edit', compact(
            'dokumen', 'kategoris', 'kodes', 'lokasis', 'retensis',
            'statusDokumens', 'sifatDokumens', 'jenisDokumens', 'jurusans'
        ));
    }

    /**
     * Memperbarui dokumen tertentu di storage.
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        $user = Auth::user();

        // Hak Akses: Hanya Admin dan Operator yang boleh memperbarui dokumen.
        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui dokumen.');
        }
        // Jika user adalah Operator, pastikan mereka hanya bisa memperbarui dokumen dari jurusannya.
        if ($user->isOperator() && $user->jurusan_id !== $dokumen->jurusan_id) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui dokumen ini.');
        }

        // Aturan validasi untuk data input dan file (file bersifat nullable untuk update).
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'judul' => 'required|string|max:255',
            'tanggal_dokumen' => 'required|date',
            'keterangan' => 'nullable|string',
            // File bersifat nullable, tapi tetap divalidasi jika ada.
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', 
            'kategori_id' => 'required|exists:kategori,id',
            'kode_id' => 'required|exists:kode,id',
            'lokasi_id' => 'required|exists:lokasi,id',
            'retensi_id' => 'required|exists:retensi,id',
            'status_id' => 'required|exists:status_dokumen,id',
            'sifat_id' => 'required|exists:sifat_dokumen,id',
            'jenis_id' => 'required|exists:jenis_dokumen,id',
            'jurusan_id' => 'required|exists:jurusan,id',
        ]);

        // Logika upload dan pembaruan file.
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada dan file fisiknya ditemukan.
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
            // Jika tidak ada file baru diunggah, pertahankan file_path dan nama_file_asli yang sudah ada.
            $validated['file_path'] = $dokumen->file_path;
            $validated['nama_file_asli'] = $dokumen->nama_file_asli;
        }

        // Paksa jurusan_id sesuai user yang login jika peran adalah Operator.
        if ($user->isOperator() && $user->jurusan_id) {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        // Perbarui record dokumen di database.
        $dokumen->update($validated);
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Menghapus dokumen tertentu dari storage.
     */
    public function destroy(Dokumen $dokumen)
    {
        $user = Auth::user();

        // Hak Akses: Hanya Admin dan Operator yang boleh menghapus dokumen.
        if (!$user->isAdmin() && !$user->isOperator()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus dokumen.');
        }
        // Jika user adalah Operator, pastikan mereka hanya bisa menghapus dokumen dari jurusannya.
        if ($user->isOperator() && $user->jurusan_id !== $dokumen->jurusan_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus dokumen ini.');
        }

        // Hapus file fisik jika ada dan file fisiknya ditemukan.
        if ($dokumen->file_path && File::exists(public_path($dokumen->file_path))) {
            File::delete(public_path($dokumen->file_path));
        }
        
        // Hapus record dokumen dari database.
        $dokumen->delete();
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
