<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DeteksiController;
use App\Http\Controllers\ProfileController;


// user route
Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

// deteksi
Route::get('/deteksi/{id}', 'App\Http\Controllers\HasilDeteksiController@showUser')->name('deteksi.showUser');
Route::resource('deteksi', DeteksiController::class);

// artikel
Route::get('artikel', 'App\Http\Controllers\ArtikelController@indexUser')->name('artikel');
Route::get('/artikel/{id}', [ArtikelController::class, 'showUser'])->name('artikel.showUser');


//profile route
Route::get('/profile/{id}', [ProfileController::class, 'showUser'])->name('profile.show');
Route::post('/update_profil/{id}', [ProfileController::class, 'updateUser'])->name('profile.update');