<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KodeController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\RetensiController;
use App\Http\Controllers\DokumenController;
use App\Models\Dokumen; // Diperlukan untuk route dokumen.download

use App\Http\Controllers\ReportController;
use App\Http\Controllers\SuratMasukController;
use App\Models\SuratMasuk;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', function () {
    return view('landing_page.home');
});

Route::get('/', function () {
    return view('landing_page.home');
});

Route::get('/profil', function () {
    return view('landing_page.profil');
});

Route::get('/arsipstatic', function () {
    return view('landing_page.arsip_statis');
});

Route::get('/arsipdinamis', function () {
    return view('landing_page.arsip_dinamis');
});

Route::get('/laporanarsip', function () {
    return view('landing_page.laporan_arsip');
});

// Rute Autentikasi Kustom Anda
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [UserController::class, 'showRegister'])->name('register'); // Register di UserController
Route::post('/register', [UserController::class, 'register']); // Register di UserController

Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');  
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');


// --- Grup Rute yang Membutuhkan Autentikasi (`auth` middleware) ---
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('layouts.dashboard');
    })->name('dashboard');

    // Tabel User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    // Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // Tabel Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    // Route::get('/kategori/{kategori}', [KategoriController::class, 'show'])->name('kategori.show');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Tabel Kode
    Route::get('/kode', [KodeController::class, 'index'])->name('kode.index');
    Route::get('/kode/create', [KodeController::class, 'create'])->name('kode.create');
    Route::post('/kode', [KodeController::class, 'store'])->name('kode.store');
    // Route::get('/kode/{kode}', [KodeController::class, 'show'])->name('kode.show');
    Route::get('/kode/{kode}/edit', [KodeController::class, 'edit'])->name('kode.edit');
    Route::put('/kode/{kode}', [KodeController::class, 'update'])->name('kode.update');
    Route::delete('/kode/{kode}', [KodeController::class, 'destroy'])->name('kode.destroy');

    // Tabel Lokasi
    Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::get('/lokasi/create', [LokasiController::class, 'create'])->name('lokasi.create');
    Route::post('/lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
    // Route::get('/lokasi/{lokasi}', [LokasiController::class, 'show'])->name('lokasi.show');
    Route::get('/lokasi/{lokasi}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
    Route::put('/lokasi/{lokasi}', [LokasiController::class, 'update'])->name('lokasi.update');
    Route::delete('/lokasi/{lokasi}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

    // Tabel Berita
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show'); // Berita memiliki metode show
    Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    // Tabel Jurusan
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::get('/jurusan/{jurusan}', [JurusanController::class, 'show'])->name('jurusan.show'); // Jurusan memiliki metode show
    Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
    Route::put('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

    // Tabel Divisi
    Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi.index');
    Route::get('/divisi/create', [DivisiController::class, 'create'])->name('divisi.create');
    Route::post('/divisi', [DivisiController::class, 'store'])->name('divisi.store');
    Route::get('/divisi/{divisi}', [DivisiController::class, 'show'])->name('divisi.show');
    Route::get('/divisi/{divisi}/edit', [DivisiController::class, 'edit'])->name('divisi.edit');
    Route::put('/divisi/{divisi}', [DivisiController::class, 'update'])->name('divisi.update');
    Route::delete('/divisi/{divisi}', [DivisiController::class, 'destroy'])->name('divisi.destroy');

    // Tabel Retensi
    Route::get('/retensi', [RetensiController::class, 'index'])->name('retensi.index');
    Route::get('/retensi/create', [RetensiController::class, 'create'])->name('retensi.create');
    Route::post('/retensi', [RetensiController::class, 'store'])->name('retensi.store');
    // Route::get('/retensi/{retensi}', [RetensiController::class, 'show'])->name('retensi.show');
    Route::get('/retensi/{retensi}/edit', [RetensiController::class, 'edit'])->name('retensi.edit');
    Route::put('/retensi/{retensi}', [RetensiController::class, 'update'])->name('retensi.update');
    Route::delete('/retensi/{retensi}', [RetensiController::class, 'destroy'])->name('retensi.destroy');

    // Tabel Dokumen (CRUD utama)
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])->name('dokumen.show');
    Route::get('/dokumen/{dokumen}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('/dokumen/{dokumen}', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::delete('/dokumen/{dokumen}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');

    // Rute khusus untuk mendownload file dokumen dari public_path
    Route::get('/dokumen/{dokumen}/download', function(Dokumen $dokumen) {
        $user = Auth::user();

        // Hak Akses: Admin bisa download semua dokumen.
        // Operator atau Pimpinan hanya bisa download dokumen dari jurusannya.
        if (($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id !== $dokumen->jurusan_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh dokumen ini.');
        }

        $filePath = public_path($dokumen->file_path);

        if (File::exists($filePath)) {
            return response()->download($filePath, $dokumen->nama_file_asli);
        } else {
            abort(404, 'File dokumen tidak ditemukan.');
        }
    })->name('dokumen.download');

    // Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');


    // Tabel Surat Masuk (CRUD utama)
    Route::get('/surat_masuk', [SuratMasukController::class, 'index'])->name('surat_masuk.index');
    Route::get('/surat_masuk/create', [SuratMasukController::class, 'create'])->name('surat_masuk.create');
    Route::post('/surat_masuk', [SuratMasukController::class, 'store'])->name('surat_masuk.store');
    // Route::get('/surat_masuk/{surat_masuk}', [SuratMasukController::class, 'show'])->name('surat_masuk.show');
    Route::get('/surat_masuk/{surat_masuk}/edit', [SuratMasukController::class, 'edit'])->name('surat_masuk.edit');
    Route::put('/surat_masuk/{surat_masuk}', [SuratMasukController::class, 'update'])->name('surat_masuk.update');
    Route::delete('/surat_masuk/{surat_masuk}', [SuratMasukController::class, 'destroy'])->name('surat_masuk.destroy');

    // Rute khusus untuk mendownload file surat masuk dari public_path
    Route::get('/surat_masuk/{surat_masuk}/download', function(SuratMasuk $surat_masuk) {
        $user = Auth::user();
        if (($user->isOperator() || $user->isPimpinan()) && $user->jurusan_id !== $surat_masuk->jurusan_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh surat masuk ini.');
        }
        $filePath = public_path($surat_masuk->file_surat_path);
        if (File::exists($filePath)) {
            return response()->download($filePath, $surat_masuk->nama_file_surat_asli);
        } else {
            abort(404, 'File surat masuk tidak ditemukan.');
        }
    })->name('surat_masuk.download'); 
});
