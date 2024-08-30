<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

// Rute untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk menampilkan formulir registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Rute untuk menangani data registrasi
Route::post('/register', [RegisterController::class, 'register']);


