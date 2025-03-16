<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deteksi extends Model
{
    protected $table = 'riwayat_deteksi';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tanggal_lahir',
        'usia',
        'kategori_usia',
        'hpht',
        'lila',
        'kategori_lila',
        'tb_ibu',
        'kategori_tb',
        'jumlah_anak',
        'kategori_anak',
        'jumlah_ttd',
        'kategori_ttd',
        'jumlah_anc',
        'kategori_anc',
        'tekanan_darah',
        'kategori_td',
        'hb',
        'kategori_hb',
        'hasil_deteksi',
    ];

    // Relasi Many to One: Deteksi -> User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}