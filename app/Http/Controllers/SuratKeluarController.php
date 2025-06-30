<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\Jurusan;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = SuratKeluar::with(['jurusan', 'divisi', 'user']);
        if ($user->isAdmin()) {
        } elseif ($user->isSekretaris()) {
        } elseif ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
            if ($user->divisi_id) {
                $query->where('divisi_id', $user->divisi_id);
            }
        } elseif ($user->isOperator()) {
            $query->where('user_id', $user->id);
        } else {
            $query->whereRaw('1 = 0');
        }

        $query->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                    ->orWhere('nomor_surat_keluar', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%")
                    ->orWhere('tujuan_surat', 'like', "%{$search}%")
                    ->orWhere('pengirim', 'like', "%{$search}%")
                    ->orWhere('penerima', 'like', "%{$search}%");
            });
        });

        if ($request->status_surat) {
            $query->where('status_surat', $request->status_surat);
        }

        if ($request->jenis_surat) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        $suratKeluars = $query->latest()->paginate(10)->withQueryString();

        // Ubah status ke 'Baru' jika penerima membuka surat keluar yang statusnya 'Terkirim'
        foreach ($suratKeluars as $surat) {
            if ($user->name === $surat->penerima && $surat->status_surat === 'Terkirim') {
                $surat->update(['status_surat' => 'Baru']);
                $surat->status_surat = 'Baru'; // update di koleksi agar tampilan langsung berubah
            }
        }

        return view('surat_keluar.index', compact('suratKeluars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$this->canAccessSuratKeluar($user, null)) {
            return redirect()->route('surat_keluar.index')->with('error', 'Anda tidak memiliki akses untuk membuat surat keluar.');
        }

        $jurusans = Jurusan::all();
        $divisis = Divisi::all();
        $users = User::all();

        return view('surat_keluar.create', compact('jurusans', 'divisis', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$this->canAccessSuratKeluar($user, null)) {
            return redirect()->route('surat_keluar.index')->with('error', 'Anda tidak memiliki akses untuk membuat surat keluar.');
        }

        $validated = $request->validate([
            'nomor_agenda' => 'required|string|unique:surat_keluars,nomor_agenda',
            'nomor_surat_keluar' => 'required|string|unique:surat_keluars,nomor_surat_keluar',
            'tanggal_surat' => 'required|date',
            'tujuan_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'isi_surat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'divisi_id' => 'nullable|exists:divisis,id',
            'sifat_surat' => 'required|in:Sangat Penting,Penting,Biasa',
            'jenis_surat' => 'required|in:Surat Undangan,Surat Pemberitahuan,Surat Permohonan,Surat Keputusan,Surat Edaran,Surat Tugas,Surat Pengantar,Surat Keterangan,Surat Lainnya',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Logika status otomatis
        // Status Baru jika semua field wajib terisi dan isi_surat serta keterangan tidak kosong
        $requiredFields = [
            'nomor_agenda', 'nomor_surat_keluar', 'tanggal_surat', 'tujuan_surat', 
            'perihal', 'pengirim', 'penerima', 'sifat_surat', 'jenis_surat'
        ];
        
        $allRequiredFilled = true;
        foreach ($requiredFields as $field) {
            if (empty($validated[$field])) {
                $allRequiredFilled = false;
                break;
            }
        }
        
        if ($allRequiredFilled && !empty($validated['isi_surat']) && !empty($validated['keterangan'])) {
            $validated['status_surat'] = 'Terkirim';
        } else {
            $validated['status_surat'] = 'Draft';
        }

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'surat_keluar_upload/' . $fileName;
            
            // Simpan file ke public/surat_keluar_upload
            $file->move(public_path('surat_keluar_upload'), $fileName);
            
            $validated['file_surat_path'] = $filePath;
            $validated['nama_file_surat_asli'] = $file->getClientOriginalName();
        }

        $validated['user_id'] = $user->id;

        if ($user->isOperator() && $user->jurusan_id) {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        if ($user->divisi_id) {
            $validated['divisi_id'] = $user->divisi_id;
        }

        SuratKeluar::create($validated);

        return redirect()->route('surat_keluar.index')->with('success', 'Surat keluar berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah penerima surat
        if ($user->name === $suratKeluar->penerima) {
            return redirect()->route('surat_keluar.index')->with('error', 'Penerima surat tidak dapat mengedit surat keluar.');
        }
        
        if (!$this->canAccessSuratKeluar($user, $suratKeluar)) {
            return redirect()->route('surat_keluar.index')->with('error', 'Anda tidak memiliki akses untuk mengedit surat keluar ini.');
        }

        // Admin bisa edit apapun statusnya, user lain hanya bisa edit Draft
        if (!$user->isAdmin() && $suratKeluar->status_surat !== 'Draft') {
            return redirect()->route('surat_keluar.index')->with('error', 'Surat keluar yang sudah dikirim tidak dapat diedit.');
        }

        $jurusans = Jurusan::all();
        $divisis = Divisi::all();
        $users = User::all();

        return view('surat_keluar.edit', compact('suratKeluar', 'jurusans', 'divisis', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah penerima surat
        if ($user->name === $suratKeluar->penerima) {
            return redirect()->route('surat_keluar.index')->with('error', 'Penerima surat tidak dapat mengupdate surat keluar.');
        }
        
        if (!$this->canAccessSuratKeluar($user, $suratKeluar)) {
            return redirect()->route('surat_keluar.index')->with('error', 'Anda tidak memiliki akses untuk mengupdate surat keluar ini.');
        }

        // Admin bisa update apapun statusnya, user lain hanya bisa update Draft
        if (!$user->isAdmin() && $suratKeluar->status_surat !== 'Draft') {
            return redirect()->route('surat_keluar.index')->with('error', 'Surat keluar yang sudah dikirim tidak dapat diupdate.');
        }

        $validated = $request->validate([
            'nomor_agenda' => 'required|string|unique:surat_keluars,nomor_agenda,' . $suratKeluar->id,
            'nomor_surat_keluar' => 'required|string|unique:surat_keluars,nomor_surat_keluar,' . $suratKeluar->id,
            'tanggal_surat' => 'required|date',
            'tujuan_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'isi_surat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'divisi_id' => 'nullable|exists:divisis,id',
            'sifat_surat' => 'required|in:Sangat Penting,Penting,Biasa',
            'jenis_surat' => 'required|in:Surat Undangan,Surat Pemberitahuan,Surat Permohonan,Surat Keputusan,Surat Edaran,Surat Tugas,Surat Pengantar,Surat Keterangan,Surat Lainnya',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Logika status otomatis
        // Status Baru jika semua field wajib terisi dan isi_surat serta keterangan tidak kosong
        $requiredFields = [
            'nomor_agenda', 'nomor_surat_keluar', 'tanggal_surat', 'tujuan_surat', 
            'perihal', 'pengirim', 'penerima', 'sifat_surat', 'jenis_surat'
        ];
        
        $allRequiredFilled = true;
        foreach ($requiredFields as $field) {
            if (empty($validated[$field])) {
                $allRequiredFilled = false;
                break;
            }
        }
        
        if ($allRequiredFilled && !empty($validated['isi_surat']) && !empty($validated['keterangan'])) {
            $validated['status_surat'] = 'Terkirim';
        } else {
            $validated['status_surat'] = 'Draft';
        }

        if ($request->hasFile('file_surat')) {
            // Hapus file lama jika ada
            if ($suratKeluar->file_surat_path && File::exists(public_path($suratKeluar->file_surat_path))) {
                File::delete(public_path($suratKeluar->file_surat_path));
            }

            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'surat_keluar_upload/' . $fileName;
            
            // Simpan file baru ke public/surat_keluar_upload
            $file->move(public_path('surat_keluar_upload'), $fileName);
            
            $validated['file_surat_path'] = $filePath;
            $validated['nama_file_surat_asli'] = $file->getClientOriginalName();
        }

        $suratKeluar->update($validated);

        return redirect()->route('surat_keluar.index')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah penerima surat
        if ($user->name === $suratKeluar->penerima) {
            return redirect()->route('surat_keluar.index')->with('error', 'Penerima surat tidak dapat menghapus surat keluar.');
        }
        
        if (!$this->canAccessSuratKeluar($user, $suratKeluar)) {
            return redirect()->route('surat_keluar.index')->with('error', 'Anda tidak memiliki akses untuk menghapus surat keluar ini.');
        }

        // Admin bisa hapus apapun statusnya, user lain hanya bisa hapus Draft
        if (!$user->isAdmin() && $suratKeluar->status_surat !== 'Draft') {
            return redirect()->route('surat_keluar.index')->with('error', 'Surat keluar yang sudah dikirim tidak dapat dihapus.');
        }

        // Hapus file jika ada
        if ($suratKeluar->file_surat_path && File::exists(public_path($suratKeluar->file_surat_path))) {
            File::delete(public_path($suratKeluar->file_surat_path));
        }

        $suratKeluar->delete();

        return redirect()->route('surat_keluar.index')->with('success', 'Surat keluar berhasil dihapus.');
    }

    /**
     * Update status surat keluar
     */
    public function updateStatus(Request $request, SuratKeluar $suratKeluar)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah penerima surat
        if ($user->name === $suratKeluar->penerima) {
            return redirect()->route('surat_keluar.index')->with('error', 'Penerima surat tidak dapat mengupdate status surat keluar.');
        }
        
        if (!$this->canAccessSuratKeluar($user, $suratKeluar)) {
            return redirect()->route('surat_keluar.index')->with('error', 'Anda tidak memiliki akses untuk mengubah status surat keluar ini.');
        }

        $request->validate([
            'status_surat' => 'required|in:Draft,Terkirim,Diterima,Dibaca,Selesai,Diarsipkan',
        ]);

        $suratKeluar->update(['status_surat' => $request->status_surat]);

        return redirect()->route('surat_keluar.index')->with('success', 'Status surat keluar berhasil diperbarui.');
    }

    /**
     * Print surat keluar
     */
    public function print(SuratKeluar $suratKeluar)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah penerima surat atau memiliki akses
        $authorized = $user->isAdmin() ||
            $suratKeluar->user_id === $user->id ||
            $user->name === $suratKeluar->penerima ||
            $user->isSekretaris() ||
            ($user->isPimpinan() && $user->divisi_id == $suratKeluar->divisi_id) ||
            ($user->isOperator() && $suratKeluar->user_id === $user->id);

        abort_unless($authorized, 403);

        // Jika penerima dan status 'Baru', ubah ke 'Dibaca'
        if ($user->name === $suratKeluar->penerima && $suratKeluar->status_surat === 'Baru') {
            $suratKeluar->update(['status_surat' => 'Dibaca']);
        }

        return view('surat_keluar.print', compact('suratKeluar'));
    }

    /**
     * Download file surat keluar
     */
    public function download(SuratKeluar $suratKeluar)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah penerima surat
        if ($user->name === $suratKeluar->penerima) {
            return redirect()->route('surat_keluar.index')->with('error', 'Penerima surat tidak dapat mengunduh file surat keluar.');
        }
        
        if (!$this->canAccessSuratKeluar($user, $suratKeluar)) {
            return redirect()->route('surat_keluar.index')->with('error', 'Anda tidak memiliki akses untuk mengunduh file ini.');
        }

        if (!$suratKeluar->file_surat_path || !File::exists(public_path($suratKeluar->file_surat_path))) {
            return redirect()->route('surat_keluar.index')->with('error', 'File tidak ditemukan.');
        }

        return response()->download(public_path($suratKeluar->file_surat_path), $suratKeluar->nama_file_surat_asli);
    }

    /**
     * Check if user can access surat keluar
     */
    private function canAccessSuratKeluar($user, $suratKeluar)
    {
        // Jika suratKeluar null (untuk operasi create), hanya cek role
        if ($suratKeluar === null) {
            if ($user->isAdmin() || $user->isSekretaris()) {
                return true;
            }

            if ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
                return true;
            }

            if ($user->isOperator()) {
                return true;
            }

            return false;
        }
        
        // Penerima surat hanya bisa print, tidak bisa akses lainnya
        if ($user->name === $suratKeluar->penerima) {
            return false;
        }
        
        if ($user->isAdmin() || $user->isSekretaris()) {
            return true;
        }

        if ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
            return $suratKeluar->divisi_id === $user->divisi_id;
        }

        if ($user->isOperator()) {
            return $suratKeluar->user_id === $user->id;
        }

        return false;
    }
}
