<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::all();
        return view('admin.users.user',compact('pengguna'));
    }

    public function reset(string $id)
{
    User::where('id', $id)->update(['password' => Hash::make('password123')]);

    return redirect()->back()->with('success', 'Password berhasil direset ke password123!');
}

    
    public function create()
    {
        return view('admin.users.tambah_user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // $pengguna = User::all();
    $request->validate([
        'username' => 'required',
        'nama_lengkap' => 'required',
        'tanggal_lahir' => 'required',
        'email' => 'required',
        'password' => 'required',
    ]);

    $pengguna = new User();
    $pengguna->username = $request->username;
    $pengguna->nama_lengkap = $request->nama_lengkap;
    $pengguna->tanggal_lahir = $request->tanggal_lahir;
    $pengguna->email = $request->email;
    $pengguna->password = Hash::make($request->password);
    $pengguna->save();

    // return view('admin.users.user',compact('pengguna'));
    return redirect()->back();
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengguna = User::findOrFail($id);
        $pengguna->delete();
        return redirect()->back();
    }
}