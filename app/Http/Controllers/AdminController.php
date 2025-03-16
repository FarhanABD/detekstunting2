<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ambil data artikel terbaru dari database
        $artikels = Artikel::orderBy('tanggal', 'desc')->get();
        $user = Auth::user();
        return view('admin.dashboard',compact('artikels','user'));
    }
}