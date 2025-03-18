<?php

namespace App\Exports;

use App\Models\Deteksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HasilDeteksiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function collection()
    {
        return Deteksi::where('user_id', $this->user_id)->get([
            'nama_lengkap', 'kategori_usia', 'kategori_lila', 'kategori_tb',
            'kategori_anak', 'kategori_ttd', 'kategori_anc', 'kategori_td',
            'kategori_hb', 'hasil_deteksi', 'created_at'
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap', 'Kategori Usia', 'Kategori LILA', 'Kategori TB',
            'Kategori Anak', 'Kategori TTD', 'Kategori ANC', 'Kategori TD',
            'Kategori HB', 'Hasil Deteksi', 'Tanggal Deteksi'
        ];
    }
}