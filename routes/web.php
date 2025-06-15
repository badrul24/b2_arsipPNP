<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KodeController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\RetensiController;
use App\Http\Controllers\StatusDokumenController;
use App\Http\Controllers\SifatDokumenController;
use App\Http\Controllers\JenisDokumenController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Tabel User
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);

// Tabel Kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

// Tabel Kode
Route::get('/kode', [KodeController::class, 'index'])->name('kode.index');
Route::get('/kode/create', [KodeController::class, 'create'])->name('kode.create');
Route::post('/kode', [KodeController::class, 'store'])->name('kode.store');
Route::get('/kode/{kode}/edit', [KodeController::class, 'edit'])->name('kode.edit');
Route::put('/kode/{kode}', [KodeController::class, 'update'])->name('kode.update');
Route::delete('/kode/{kode}', [KodeController::class, 'destroy'])->name('kode.destroy');

// Tabel Lokasi
Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
Route::get('/lokasi/create', [LokasiController::class, 'create'])->name('lokasi.create');
Route::post('/lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
Route::get('/lokasi/{lokasi}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
Route::put('/lokasi/{lokasi}', [LokasiController::class, 'update'])->name('lokasi.update');
Route::delete('/lokasi/{lokasi}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

// Tabel Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');

Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
Route::get('/jurusan/{jurusan}', [JurusanController::class, 'show'])->name('jurusan.show');
Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
Route::put('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

// Tabel Hak Akses
Route::get('/hak-akses', [HakAksesController::class, 'index'])->name('hak-akses.index');
Route::get('/hak-akses/create', [HakAksesController::class, 'create'])->name('hak-akses.create');
Route::post('/hak-akses', [HakAksesController::class, 'store'])->name('hak-akses.store');
Route::get('/hak-akses/{hakAkses}/edit', [HakAksesController::class, 'edit'])->name('hak-akses.edit');
Route::put('/hak-akses/{hakAkses}', [HakAksesController::class, 'update'])->name('hak-akses.update');
Route::delete('/hak-akses/{hakAkses}', [HakAksesController::class, 'destroy'])->name('hak-akses.destroy');

// Tabel Retensi
Route::get('/retensi', [RetensiController::class, 'index'])->name('retensi.index');
Route::get('/retensi/create', [RetensiController::class, 'create'])->name('retensi.create');
Route::post('/retensi', [RetensiController::class, 'store'])->name('retensi.store');
Route::get('/retensi/{retensi}/edit', [RetensiController::class, 'edit'])->name('retensi.edit');
Route::put('/retensi/{retensi}', [RetensiController::class, 'update'])->name('retensi.update');
Route::delete('/retensi/{retensi}', [RetensiController::class, 'destroy'])->name('retensi.destroy');

// Tabel Status Dokumen
Route::get('/status-dokumen', [StatusDokumenController::class, 'index'])->name('statusDokumen.index');
Route::get('/status-dokumen/create', [StatusDokumenController::class, 'create'])->name('statusDokumen.create');
Route::post('/status-dokumen', [StatusDokumenController::class, 'store'])->name('statusDokumen.store');
Route::get('/status-dokumen/{statusDokumen}/edit', [StatusDokumenController::class, 'edit'])->name('statusDokumen.edit');
Route::put('/status-dokumen/{statusDokumen}', [StatusDokumenController::class, 'update'])->name('statusDokumen.update');
Route::delete('/status-dokumen/{statusDokumen}', [StatusDokumenController::class, 'destroy'])->name('statusDokumen.destroy');

// Tabel Sifat Dokumen
Route::get('/sifat-dokumen', [SifatDokumenController::class, 'index'])->name('sifat-dokumen.index');
Route::get('/sifat-dokumen/create', [SifatDokumenController::class, 'create'])->name('sifat-dokumen.create');
Route::post('/sifat-dokumen', [SifatDokumenController::class, 'store'])->name('sifat-dokumen.store');
Route::get('/sifat-dokumen/{sifatDokumen}/edit', [SifatDokumenController::class, 'edit'])->name('sifat-dokumen.edit');
Route::put('/sifat-dokumen/{sifatDokumen}', [SifatDokumenController::class, 'update'])->name('sifat-dokumen.update');
Route::delete('/sifat-dokumen/{sifatDokumen}', [SifatDokumenController::class, 'destroy'])->name('sifat-dokumen.destroy');

// Tabel Jenis Dokumen
Route::get('/jenis-dokumen', [JenisDokumenController::class, 'index'])->name('jenis-dokumen.index');
Route::get('/jenis-dokumen/create', [JenisDokumenController::class, 'create'])->name('jenis-dokumen.create');
Route::post('/jenis-dokumen', [JenisDokumenController::class, 'store'])->name('jenis-dokumen.store');
Route::get('/jenis-dokumen/{jenisDokumen}/edit', [JenisDokumenController::class, 'edit'])->name('jenis-dokumen.edit');
Route::put('/jenis-dokumen/{jenisDokumen}', [JenisDokumenController::class, 'update'])->name('jenis-dokumen.update');
Route::delete('/jenis-dokumen/{jenisDokumen}', [JenisDokumenController::class, 'destroy'])->name('jenis-dokumen.destroy');
