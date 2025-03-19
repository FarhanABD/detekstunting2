<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtikelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PenggunaController;

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get('/', [AuthController::class, 'index'])->name('dashboard');
Route::get('/artikel', [ArtikelController::class, 'indexUnlogin'])->name('artikel');
Route::get('/artikel/{id}', [ArtikelController::class, 'showUnlogin'])->name('artikel.showUnlogin');


// Route::get('')
Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.auth.login');
Route::get('reset-password', [PenggunaController::class, 'Halamanreset'])->name('reset-password');
Route::post('ganti-password', [PenggunaController::class, 'resetPassword'])->name('ganti-password');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';