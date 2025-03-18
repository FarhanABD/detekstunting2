<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{

    public function index(Request $request)
    {
        // Ambil jumlah data per halaman dari dropdown (default 5)
        $perPage = $request->input('per_page', 5);
    
        // Ambil data terbaru setiap user berdasarkan created_at (hanya 1 per user)
        $hasilArtikel = Artikel::select('artikel.*')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                      ->from('artikel')
                      ->groupBy('id');
            })
            ->orderBy('id', 'asc') // Urutkan dari yang terbaru
            ->paginate($perPage);
    
        return view('admin.artikel.kelola_artikel', compact('hasilArtikel', 'perPage'));
    }

    public function indexUser(Request $request)
    {
        $artikels = Artikel::all();
        return view('user.artikel.artikel', compact('artikels'));
    }

    public function indexUnlogin(){
        $artikels = Artikel::all();
        return view('artikel',compact('artikels'));
    }

   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.artikel.tambah_artikel');
    }

    

public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'deskripsi' => 'required',
        'tanggal' => 'nullable',
    ]);

    $gambar = $request->file('gambar');
    $namaFile = time() . '_' . $gambar->getClientOriginalName();

    // Simpan gambar langsung ke public/storage/images
    $gambarPath = 'storage/images/' . $namaFile;
    $gambar->move(public_path('storage/images'), $namaFile);

    $artikel = new Artikel;
    $artikel->judul = $request->judul;
    $artikel->gambar = $gambarPath; // Simpan path yang sesuai
    $artikel->deskripsi = $request->deskripsi;
    $artikel->tanggal = $request->tanggal ?? now();
    $artikel->save();

    return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
}



    public function show(string $id)
{
    $artikel = Artikel::find($id);
    $berita = Artikel::all();

    if (!$artikel) {
        return redirect()->route('admin.artikel.index')->with('error', 'Data tidak ditemukan');
    }

    return view('admin.artikel.view_artikel', compact('artikel','berita'));
}

public function showUser(string $id)
{
    $artikel = Artikel::find($id); // Jika tidak ditemukan, error 404 otomatis
    $berita = Artikel::all();

    return view('user.artikel.artikel', compact('artikel', 'berita'));
}



    public function showUnlogin(string $id)
{
    $artikel = Artikel::find($id);
    $berita = Artikel::all();

    if (!$artikel) {
        return redirect()->route('artikel')->with('error', 'Data tidak ditemukan');
    }

    return view('artikel', compact('artikel','berita'));
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