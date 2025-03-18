<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function index(){
         // Ambil artikel terbaru
        $artikels = Artikel::orderBy('tanggal', 'desc')->get();
        $berita = $artikels->first(); // Ambil satu artikel terbaru
       
         $user = Auth::user();
     
         return view('dashboard', compact('artikels', 'user', 'berita'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}