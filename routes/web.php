<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\PublicController;


Route::get('/', function () {
    return view('user');
});

Route::get('/seben', function () {
    return view('fitur');
});

Route::get('/profil', function () {
    return view('users.profil');
});

Route::get('/home', function () {
    return view('users.home');
});

Route::get('/arsipstatic', function () {
    return view('users.arsipstatic');
});


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('layouts.index');
})->middleware('auth');


// Tabel Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');


// Tabel Codes
Route::get('/codes', [CodeController::class, 'index'])->name('code.index');
Route::get('/codes/create', [CodeController::class, 'create'])->name('code.create');
Route::post('/codes', [CodeController::class, 'store'])->name('code.store');
Route::get('/codes/{code}/edit', [CodeController::class, 'edit'])->name('code.edit');
Route::put('/codes/{code}', [CodeController::class, 'update'])->name('code.update');
Route::delete('/codes/{code}', [CodeController::class, 'destroy'])->name('code.destroy');


//Tampilan Public
Route::get('/home',[PublicController::class, 'home'])->name('home');

