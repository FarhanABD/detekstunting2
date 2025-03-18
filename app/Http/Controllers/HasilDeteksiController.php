<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HasilDeteksiExport;
use App\Models\Deteksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class HasilDeteksiController extends Controller
{
    
    public function index(Request $request)
    {
        // Ambil jumlah data per halaman dari dropdown (default 5)
        $perPage = $request->input('per_page', 5);
    
        // Ambil data terbaru setiap user berdasarkan created_at (hanya 1 per user)
        $hasilDeteksi = Deteksi::select('riwayat_deteksi.*')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                      ->from('riwayat_deteksi')
                      ->groupBy('user_id');
            })
            ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
            ->paginate($perPage);
    
        return view('admin.hasil-deteksi.kelola_hasildetek', compact('hasilDeteksi', 'perPage'));
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
    public function show($user_id)
    {
        $hasilDeteksi = Deteksi::where('user_id', $user_id)->get();
    
        if ($hasilDeteksi->isEmpty()) {
            return redirect()->route('admin.hasilDeteksi.index')->with('error', 'Riwayat tidak ditemukan');
        }
    
        return view('admin.hasil-deteksi.riwayat_user', compact('hasilDeteksi'));
    }

    public function exportExcel($user_id)
{
    return Excel::download(new HasilDeteksiExport($user_id), 'riwayat_deteksi.xlsx');
}

public function exportPDF($user_id)
{
    $hasilDeteksi = Deteksi::where('user_id', $user_id)->get();

    if ($hasilDeteksi->isEmpty()) {
        return redirect()->route('admin.hasilDeteksi.index')->with('error', 'Riwayat tidak ditemukan');
    }

    $pdf = PDF::loadView('admin.hasil-deteksi.export_pdf', compact('hasilDeteksi'))
          ->setPaper('a4', 'landscape'); // Mengatur kertas A4 landscape

    return $pdf->download('riwayat_deteksi.pdf');
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