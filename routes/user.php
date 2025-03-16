<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeteksiController;
use App\Http\Controllers\ProfileController;


// user route
Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

// deteksi
Route::resource('deteksi', DeteksiController::class);

// artikel
Route::get('artikel/{id}', 'App\Http\Controllers\ArtikelController@indexUser')->name('artikel');

//profile route
Route::get('/profile/{id}', [ProfileController::class, 'showUser'])->name('profile.show');
Route::post('/update_profil/{id}', [ProfileController::class, 'updateUser'])->name('profile.update');