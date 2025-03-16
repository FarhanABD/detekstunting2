<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deteksi;
use App\Models\User;

class DeteksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dari database
        $users = User::all();

        // Pastikan ada user sebelum menambahkan data deteksi
        if ($users->count() > 0) {
            foreach ($users as $user) {
                Deteksi::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $user->nama_lengkap,
                    'tanggal_lahir' => '2000-01-01',
                    'usia' => 25,
                    'kategori_usia' => 'Tidak berisiko',
                    'hpht' => '2025-01-01',
                    'lila' => 25.5,
                    'kategori_lila' => 'Normal',
                    'tb_ibu' => 160.5,
                    'kategori_tb' => 'Normal',
                    'jumlah_anak' => 2,
                    'kategori_anak' => 1,
                    'jumlah_ttd' => 90,
                    'kategori_ttd' => 'Cukup',
                    'jumlah_anc' => 5,
                    'kategori_anc' => 'Cukup',
                    'tekanan_darah' => '120/80',
                    'kategori_td' => 'Normal',
                    'hb' => 12.5,
                    'kategori_hb' => 'Normal',
                    'hasil_deteksi' => 'Sehat',
                ]);
            }
        } else {
            echo "Seeder gagal: Tidak ada user di database.\n";
        }
    }
}