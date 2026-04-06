<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tiket;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'tes',
            'email' => 'tes@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);
         User::create([
            'name' => 'apa',
            'email' => 'apa@gmail.com',
            'password' => Hash::make('customer'),
            'role' => 'customer'
        ]);





    }
}
