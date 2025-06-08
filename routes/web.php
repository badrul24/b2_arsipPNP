<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KodeController;
use App\Http\Controllers\LokasiController;    

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('layouts.index');
})->middleware('auth');

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
