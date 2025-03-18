<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\HasilDeteksiController;
use App\Http\Controllers\ProfileController;

// admin route
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

// artikel route
Route::resource('artikel', ArtikelController::class);

// pengguna route
Route::post('/pengguna/reset/{id}', [PenggunaController::class, 'reset'])->name('pengguna.reset');
Route::get('/hasilDeteksi/user/{user_id}', [HasilDeteksiController::class, 'show'])
    ->name('hasilDeteksi.show');

Route::resource('pengguna', PenggunaController::class);

// deteksi route
Route::get('/hasilDeteksi/export-pdf/{user_id}', [HasilDeteksiController::class, 'exportPDF'])
    ->name('hasilDeteksi.exportPDF');

Route::get('/hasilDeteksi/export/{user_id}', [HasilDeteksiController::class, 'exportExcel'])
    ->name('hasilDeteksi.export');
Route::get('/hasilDeteksi/{id}', [HasilDeteksiController::class, 'show'])->name('hasilDeteksi.show');
Route::resource('hasilDeteksi', HasilDeteksiController::class);

//profile route
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/update_profil/{id}', [ProfileController::class, 'update'])->name('profile.update');