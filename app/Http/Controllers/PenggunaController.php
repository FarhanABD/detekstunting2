<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil jumlah data per halaman dari dropdown (default 5)
        $perPage = $request->input('per_page', 5);
    
        // Ambil data terbaru setiap user berdasarkan created_at (hanya 1 per user)
        $hasilUser = User::select('users.*')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                      ->from('users')
                      ->groupBy('id');
            })
            ->orderBy('id', 'asc') // Urutkan dari yang terbaru
            ->paginate($perPage);
    
        return view('admin.users.user', compact('hasilUser', 'perPage'));
    }

    public function reset(string $id)
{
    User::where('id', $id)->update(['password' => Hash::make('password123')]);

    return redirect()->back()->with('success', 'Password berhasil direset ke password123!');
}

public function Halamanreset(){
    return view('resetPassword');
}

public function resetPassword(Request $request)
{
    $request->validate([
        'nama_lengkap' => 'required|string',
        'password_baru' => 'required|string|min:6',
    ]);

    $nama_lengkap = $request->nama_lengkap;
    $password_baru = Hash::make($request->password_baru);

    // Cek apakah pengguna ada di database
    $user = User::where('nama_lengkap', $nama_lengkap)->first();
    
    if ($user) {
        // Update password
        $user->update(['password' => $password_baru]);

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    } else {
        return redirect()->back()->with('error', 'Nama tidak ditemukan!');
    }
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
    return view('admin.users.tambah_user');
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