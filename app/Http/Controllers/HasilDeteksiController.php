<?php

namespace App\Http\Controllers;

use App\Models\Deteksi;
use Illuminate\Http\Request;

class HasilDeteksiController extends Controller
{
    
    public function index()
    {
        $hasilDeteksi = Deteksi::all();
        return view('admin.hasil-deteksi.kelola_hasildetek', compact('hasilDeteksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $hasilDeteksi = Deteksi::find($id);

    if (!$hasilDeteksi) {
        return redirect()->route('admin.hasilDeteksi.index')->with('error', 'Data tidak ditemukan');
    }

    return view('admin.hasil-deteksi.riwayat_user', compact('hasilDeteksi'));
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
        //
    }
}