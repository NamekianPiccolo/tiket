<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menambahkan user baru (tanpa menghapus yang lama)
        User::create([
            'name'      => 'Customer Baru',
            'email'     => 'customer@gmail.com', // Pastikan email belum ada di DB
            'password'  => Hash::make('password123'),
            'role'      => 'customer',
        ]);

        // Atau cara yang lebih aman agar tidak error jika dijalankan berkali-kali:
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Cek berdasarkan email
            [
                'name'     => 'Admin Spesifik',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );
    }
}
