<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        // Mitra user
        User::create([
            'name' => 'Mitra UMKM',
            'email' => 'mitra@example.com',
            'password' => Hash::make('password'),
            'role' => 'mitra',
            'phone' => '081298765432',
            'alamat' => 'Jl. Contoh No. 123',
            'is_active' => true,
        ]);

        // Regular user
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '081211223344',
            'is_active' => true,
        ]);

        // Buat beberapa user dummy
        User::factory(10)->create();
    }
}
