<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function show(string $id){
        $user = User::findorFail($id);
        return view('admin.profile.edit_profile',compact('user'));
    }
    public function showUser(string $id){
        $user = User::findorFail($id);
        $artikels = Artikel::orderBy('tanggal', 'desc')->get();
        $berita = $artikels->first(); // Ambil satu artikel terbaru
        return view('user.profile.edit_profile',compact('user','artikels', 'berita'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'username'=>'nullable',
            'nama_lengkap'=>'nullable',
            'tanggal_lahir'=>'nullable',
            'email'=>'nullable',
            'password'=>'nullable',
        ]);
        $user = User::findorFail($id);
        $user->username = $request->username;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->update($request->all());

        return redirect()->route('admin.dashboard');
    }

    public function updateUser(Request $request, string $id){
        $request->validate([
            'username'=>'nullable',
            'nama_lengkap'=>'nullable',
            'tanggal_lahir'=>'nullable',
            'email'=>'nullable',
            'password'=>'nullable',
        ]);
        $user = User::findorFail($id);
        $user->username = $request->username;
        $user->nama_lengkap = $request->nama_lengkap;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->update($request->all());

        return redirect()->route('user.dashboard');
    }
    
    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}