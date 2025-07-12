<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KodeController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RetensiController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\UserController;
use App\Models\Dokumen;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Models\Berita;
use App\Models\User;
use App\Models\Jurusan;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', function () {
    $beritas = Berita::with(['user', 'kategori'])->latest()->take(6)->get();
    $totalArsip = Dokumen::count();
    $totalPengguna = User::count();
    $totalJurusan = Jurusan::count();
    return view('landing_page.home', compact('beritas', 'totalArsip', 'totalPengguna', 'totalJurusan'));
});

Route::get('/', function () {
    $beritas = Berita::with(['user', 'kategori'])->latest()->take(6)->get();
    $totalArsip = Dokumen::count();
    $totalPengguna = User::count();
    $totalJurusan = Jurusan::count();
    return view('landing_page.home', compact('beritas', 'totalArsip', 'totalPengguna', 'totalJurusan'));
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

Route::get('/laporanarsip', [\App\Http\Controllers\LaporanArsipController::class, 'index']);

Route::get('/search', [SearchController::class, 'search'])->name('search');

// Test route to see berita data
Route::get('/test-berita', function () {
    $beritas = Berita::with(['user', 'kategori'])->get();
    return response()->json([
        'total' => $beritas->count(),
        'beritas' => $beritas->map(function ($berita) {
            return [
                'id' => $berita->id,
                'judul' => $berita->judul_berita,
                'isi' => substr($berita->isi_berita, 0, 100) . '...',
                'kategori' => $berita->kategori->nama_kategori ?? 'Tidak ada kategori',
                'user' => $berita->user->name ?? 'Tidak diketahui'
            ];
        })
    ]);
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

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/recent-items', [App\Http\Controllers\DashboardController::class, 'getRecentItemsPaginated'])->name('dashboard.recent-items');

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
    Route::get('/dokumen/{dokumen}/download', function (Dokumen $dokumen) {
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
    Route::get('/surat_masuk/{surat_masuk}/print', [SuratMasukController::class, 'print'])->name('surat_masuk.print');
    Route::post('/surat-masuk/{suratMasuk}/update-status', [SuratMasukController::class, 'updateStatus'])
    ->name('surat_masuk.updateStatus');

    // Rute khusus untuk mendownload file surat masuk dari public_path
    Route::get('/surat_masuk/{surat_masuk}/download', function (SuratMasuk $surat_masuk) {
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

    // Tabel Surat Keluar (CRUD utama)
    Route::get('/surat_keluar', [SuratKeluarController::class, 'index'])->name('surat_keluar.index');
    Route::get('/surat_keluar/create', [SuratKeluarController::class, 'create'])->name('surat_keluar.create');
    Route::post('/surat_keluar', [SuratKeluarController::class, 'store'])->name('surat_keluar.store');
    Route::get('/surat_keluar/{surat_keluar}/edit', [SuratKeluarController::class, 'edit'])->name('surat_keluar.edit');
    Route::put('/surat_keluar/{surat_keluar}', [SuratKeluarController::class, 'update'])->name('surat_keluar.update');
    Route::delete('/surat_keluar/{surat_keluar}', [SuratKeluarController::class, 'destroy'])->name('surat_keluar.destroy');
    Route::get('/surat_keluar/{surat_keluar}/print', [SuratKeluarController::class, 'print'])->name('surat_keluar.print');
    Route::get('/surat_keluar/report', [\App\Http\Controllers\SuratKeluarController::class, 'report'])->name('surat_keluar.report');

    // Rute khusus untuk mendownload file surat keluar dari public_path
    Route::get('/surat_keluar/{surat_keluar}/download', function (SuratKeluar $surat_keluar) {
        $user = Auth::user();
        
        // Cek apakah user adalah penerima surat
        if ($user->name === $surat_keluar->penerima) {
            abort(403, 'Penerima surat tidak dapat mengunduh file surat keluar.');
        }
        
        // Cek akses berdasarkan role
        if (!$user->isAdmin() && !$user->isSekretaris()) {
            if ($user->isPimpinan() || $user->isKepalaLembaga() || $user->isKepalaBidang()) {
                if ($surat_keluar->divisi_id !== $user->divisi_id) {
                    abort(403, 'Anda tidak memiliki akses untuk mengunduh surat keluar ini.');
                }
            } elseif ($user->isOperator()) {
                if ($surat_keluar->user_id !== $user->id) {
                    abort(403, 'Anda tidak memiliki akses untuk mengunduh surat keluar ini.');
                }
            } else {
                abort(403, 'Anda tidak memiliki akses untuk mengunduh surat keluar ini.');
            }
        }
        
        $filePath = public_path($surat_keluar->file_surat_path);
        if (File::exists($filePath)) {
            return response()->download($filePath, $surat_keluar->nama_file_surat_asli);
        } else {
            abort(404, 'File surat keluar tidak ditemukan.');
        }
    })->name('surat_keluar.download');

    Route::get('/disposisi', [DisposisiController::class, 'index'])->name('disposisi.index');
    Route::get('/disposisi/create', [DisposisiController::class, 'create'])->name('disposisi.create');
    Route::post('/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
    Route::get('/disposisi/{disposisi}', [DisposisiController::class, 'show'])->name('disposisi.show');
    Route::get('/disposisi/{disposisi}/edit', [DisposisiController::class, 'edit'])->name('disposisi.edit');
    Route::put('/disposisi/{disposisi}', [DisposisiController::class, 'update'])->name('disposisi.update');
    Route::delete('/disposisi/{disposisi}', [DisposisiController::class, 'destroy'])->name('disposisi.destroy');
    Route::get('/disposisi/{disposisi}/print', [DisposisiController::class, 'print'])->name('disposisi.print');
    // Rute untuk mengupdate status disposisi (digunakan oleh penerima disposisi untuk 'Selesai')
    Route::put('/disposisi/{disposisi}/update-status', [DisposisiController::class, 'updateStatus'])->name('disposisi.updateStatus');
    Route::post('/disposisi/terima/{surat_masuk}', [DisposisiController::class, 'terima'])->name('disposisi.terima');

    Route::get('surat-masuk/laporan/pdf', [SuratMasukController::class, 'report'])->name('surat_masuk.laporan.pdf');

});
