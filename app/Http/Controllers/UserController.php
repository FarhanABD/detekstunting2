<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        // Ambil artikel terbaru
        $artikels = Artikel::orderBy('tanggal', 'desc')->get();
        $berita = $artikels->first(); // Ambil artikel terbaru
        
        $user = Auth::user();
        
    
        return view('user.dashboard', compact('artikels', 'user', 'berita'));
    }
    
}