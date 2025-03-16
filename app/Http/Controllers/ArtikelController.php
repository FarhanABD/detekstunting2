<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikels = Artikel::all();
        return view('admin.artikel.kelola_artikel',compact('artikels'));

    }

    public function indexUser(string $id)
{
    $artikels = Artikel::all();
    $berita = Artikel::find($id);

    if (!$berita) {
        abort(404, 'Artikel tidak ditemukan');
    }

    return view('user.artikel.artikel', compact('artikels', 'berita'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.artikel.tambah_artikel');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'deskripsi' => 'required',
        'tanggal' => 'nullable',
    ]);

    // Simpan gambar ke folder public/images
    $gambarPath = $request->file('gambar')->store('images', 'public');

    $artikel = new Artikel;
    $artikel->judul = $request->judul;
    $artikel->gambar = $gambarPath; // Simpan path gambar di database
    $artikel->deskripsi = $request->deskripsi;
    $artikel->tanggal = $request->tanggal ?? now();
    $artikel->save();

    return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $artikel = Artikel::find($id);
    $berita = Artikel::all();

    if (!$artikel) {
        return redirect()->route('admin.artikel.index')->with('error', 'Data tidak ditemukan');
    }

    return view('admin.artikel.view_artikel', compact('artikel','berita'));
}

// public function showUser(string $id)
// {
//     $artikel = Artikel::find($id);
//     $berita = Artikel::all();

//     if (!$artikel) {
//         return redirect()->route('admin.artikel.index')->with('error', 'Data tidak ditemukan');
//     }

//     return view('user.artikel.view_artikel', compact('artikel','berita'));
// }


    public function edit(string $id)
    {
        $artikel = Artikel::findorFail($id);
        return view('admin.artikel.edit_artikel',compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'deskripsi' => 'required|string',
        'tanggal' => 'required|date',
    ]);

    $artikel = Artikel::findOrFail($id);

    // Update Data
    $artikel->judul = $request->judul;
    $artikel->deskripsi = $request->deskripsi;
    $artikel->tanggal = $request->tanggal;

    // Update Gambar (Jika ada file baru yang diunggah)
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($artikel->gambar) {
            Storage::delete('public/images/' . basename($artikel->gambar));
        }
    
        // Simpan gambar baru ke folder yang sesuai
        $gambarPath = $request->file('gambar')->store('images', 'public');
    
        // Simpan hanya path relatif ke database
        $artikel->gambar = $gambarPath;
    }
    

    $artikel->save();

    return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artikel = Artikel::findOrFail($id);
        
        // Hapus gambar dari storage jika ada
        if ($artikel->gambar) {
            Storage::delete('storage/' . $artikel->gambar);
        }
        $artikel->delete();
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus!');
    }
    
}