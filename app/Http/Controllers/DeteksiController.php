<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Deteksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DeteksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikels = Artikel::orderBy('tanggal', 'desc')->get();
        $berita = $artikels->first(); // Ambil satu artikel terbaru
        $user = Auth::user();
        $hasil_deteksi_terbaru = Deteksi::where('user_id', Auth::id())->latest()->first();
        return view('user.deteksi.detekdini', compact('user','hasil_deteksi_terbaru', 'artikels', 'berita'));
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
        $request->validate([
            'hpht' => 'required|date',
            'lila' => 'required|numeric',
            'tb_ibu' => 'required|numeric',
            'jumlah_anak' => 'required|integer',
            'jumlah_ttd' => 'required|integer',
            'jumlah_anc' => 'required|integer',
            'tekanan_darah' => 'required|string',
            'hb_ibu' => 'required|numeric',
        ]);
    
        $user = Auth::user();
        $tanggal_lahir = Carbon::parse($user->tanggal_lahir);
        $hpht = Carbon::parse($request->hpht);
        $usia = $hpht->diffInYears($tanggal_lahir);
    
        $kategori_usia = ($usia < 20 || $usia > 35) ? 'Berisiko' : 'Tidak berisiko';
        $kategori_lila = ($request->lila < 23.3) ? 'Berisiko' : 'Tidak berisiko';
        $kategori_tb = ($request->tb_ibu < 150) ? 'Pendek' : 'Tinggi';
        $kategori_anak = ($request->jumlah_anak > 2) ? 'Berisiko' : 'Tidak berisiko';
        $kategori_ttd = ($request->jumlah_ttd < 90) ? 'Kurang' : 'Cukup';
        $kategori_anc = ($request->jumlah_anc < 6) ? 'Kurang' : 'Lengkap';
    
        list($sistolik, $diastolik) = explode("/", str_replace(' ', '', $request->tekanan_darah));
    
        if ($diastolik < 60) {
            $kategori_td = 'Hipotensi';
        } elseif ($sistolik >= 130 && $diastolik >= 90) {
            $kategori_td = 'Hipertensi';
        } else {
            $kategori_td = 'Normal';
        }
    
        if ($request->hb_ibu < 7) {
            $kategori_hb = 'Anemia berat';
        } elseif ($request->hb_ibu >= 7 && $request->hb_ibu <= 8) {
            $kategori_hb = 'Anemia sedang';
        } elseif ($request->hb_ibu >= 9 && $request->hb_ibu <= 10) {
            $kategori_hb = 'Anemia ringan';
        } else {
            $kategori_hb = 'Normal';
        }
    
        // Panggil fungsi deteksiStunting
        $hasil_deteksi = $this->deteksiStunting(
            $kategori_hb,
            $kategori_ttd,
            $kategori_lila,
            $kategori_usia,
            $kategori_anak,
            $kategori_tb,
            $kategori_td,
            $kategori_anc
        );
    
        // Simpan ke database
        Deteksi::create([
            'user_id' => $user->id,
            'nama_lengkap' => $user->nama_lengkap,
            'tanggal_lahir' => $user->tanggal_lahir,
            'usia' => $usia,
            'kategori_usia' => $kategori_usia,
            'hpht' => $request->hpht,
            'lila' => $request->lila,
            'kategori_lila' => $kategori_lila,
            'tb_ibu' => $request->tb_ibu,
            'kategori_tb' => $kategori_tb,
            'jumlah_anak' => $request->jumlah_anak,
            'kategori_anak' => $kategori_anak,
            'jumlah_ttd' => $request->jumlah_ttd,
            'kategori_ttd' => $kategori_ttd,
            'jumlah_anc' => $request->jumlah_anc,
            'kategori_anc' => $kategori_anc,
            'tekanan_darah' => $request->tekanan_darah,
            'kategori_td' => $kategori_td,
            'hb' => $request->hb_ibu,
            'kategori_hb' => $kategori_hb,
            'hasil_deteksi' => $hasil_deteksi,
        ]);
    
        // Simpan hasil deteksi ke session agar bisa diakses di Blade
        return redirect()->route('user.deteksi.index')->with('hasil_deteksi', $hasil_deteksi);
    }


    // Fungsi deteksiStunting
    private function deteksiStunting($hb, $ttd, $lila, $usia, $jumlah_anak, $tinggi_badan_ibu, $tekanan_darah, $anc)
    {
        if ($hb == "Anemia ringan") {
            if ($jumlah_anak == "Berisiko") {
                return "STUNTING";
            } else { // jumlah anak = Tidak Berisiko
                return "NORMAL";
            }
        } elseif ($hb == "Anemia sedang") {
            if ($usia == "Berisiko") {
                return "STUNTING";
            } else { // usia = Tidak Berisiko
                return "NORMAL";
            }
        } elseif ($hb == "Normal") {
            if ($ttd == "Kurang") {
                return "STUNTING";
            } else if ($ttd == "Cukup") {
                if ($lila == "Berisiko") {
                    if ($usia == "Berisiko") {
                        return "NORMAL";
                    } else if ($usia == "Tidak berisiko") {
                        if ($tinggi_badan_ibu == "Pendek") {
                            if ($tekanan_darah == "Hipotensi") {
                                return "NORMAL";
                            } else { // tekanan darah = Normal
                                return "STUNTING";
                            }
                        } else { // tinggi badan ibu = Tinggi
                            return "NORMAL";
                        }
                    }
                } else if ($lila == "Tidak berisiko") {
                    if ($tekanan_darah == "Hipertensi") {
                        return "NORMAL";
                    } else if ($tekanan_darah == "Hipotensi") {
                        if ($jumlah_anak == "Berisiko") {
                            return "NORMAL";
                        } else if ($jumlah_anak == "Tidak berisiko") {
                            if ($anc == "Kurang") {
                                return "STUNTING";
                            } else if ($anc == "Lengkap") {
                                if ($usia == "Berisiko") {
                                    return "NORMAL";
                                } else { // usia = Tidak Berisiko
                                    return "STUNTING";
                                }
                            }
                        }
                    } else if ($tekanan_darah == "Normal") {
                        if ($usia == "Berisiko") {
                            return "STUNTING";
                        } else if ($usia == "Tidak berisiko") {
                            if ($jumlah_anak == "Berisiko") {
                                if ($tinggi_badan_ibu == "Pendek") {
                                    return "NORMAL";
                                } else { // tinggi badan ibu = Tinggi
                                    return "STUNTING";
                                }
                            } else if ($jumlah_anak == "Tidak berisiko") {
                                if ($tinggi_badan_ibu == "Pendek") {
                                    if ($anc == "Kurang") {
                                        return "NORMAL";
                                    } else { // anc = Lengkap
                                        return "STUNTING";
                                    }
                                } else { // tinggi badan ibu = Tinggi
                                    return "NORMAL";
                                }
                            }
                        }
                    }
                }
            }
        }
        return "mbuh"; // Default jika tidak masuk ke kondisi mana pun
    }
    
    public function show(string $id, Request $request)
{
    // Ambil jumlah data per halaman dari dropdown (default 5)
    $perPage = $request->input('per_page', 5);

     // Ambil data terbaru setiap user berdasarkan created_at (hanya 1 per user)
     $hasilRiwayat = Deteksi::select('riwayat_deteksi.*')
     ->whereIn('id', function ($query) {
         $query->selectRaw('MAX(id)')
               ->from('riwayat_deteksi')
               ->groupBy('id');
     })
     ->orderBy('id', 'asc') // Urutkan dari yang terbaru
     ->paginate($perPage);

    $artikels = Artikel::orderBy('tanggal', 'desc')->get();
    $berita = $artikels->first(); // Ambil satu artikel terbaru
    $riwayatDetek = Deteksi::where('user_id', $id)->get(); // Pastikan query menghasilkan data
    return view('user.riwayat-deteksi.riwayatdetek', compact('riwayatDetek','artikels', 'berita','hasilRiwayat'));
}


   
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