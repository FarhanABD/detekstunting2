<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa user dummy
        User::create([
            'username' => 'najwa',
            'nama_lengkap' => 'Najwa Amalia',
            'tanggal_lahir' => '2000-01-01',
            'email' => 'najwa@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        User::create([
            'username' => 'gus',
            'nama_lengkap' => 'gus gusan',
            'tanggal_lahir' => '2000-01-01',
            'email' => 'gus@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

    
    }
}