<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        echo "🚀 Memulai seeder users...\n";

        // Hapus data lama
        DB::table('users')->truncate();

        // 1. User ADMIN (penting untuk login)
        DB::table('users')->insert([
            'name' => 'Oza Admin UMKM',
            'email' => 'ozaadmin@umkm.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'alamat' => 'Kantor Desa',
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Admin user dibuat: ozaadmin@umkm.com / admin123\n";

        // 2. User MITRA (pemilik UMKM)
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => 'mitra' . $i . '@umkm.com',
                'email_verified_at' => now(),
                'password' => Hash::make('mitra123'),
                'alamat' => $faker->address(),
                'role' => 'mitra',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "✅ Mitra user $i dibuat\n";
        }

        // 3. User BIASA (warga/pembeli)
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => 'user' . $i . '@umkm.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'alamat' => $faker->address(),
                'role' => 'user',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        echo "✅ 20 user biasa dibuat\n";

        echo "🎉 Seeder users selesai! Total 31 user dibuat.\n";
        echo "📋 Login info:\n";
        echo "   - Admin: ozaadmin@umkm.com / admin123\n";
        echo "   - Mitra: ozamitra@umkm.com / mitra123\n";
        echo "   - User: ozauser@umkm.com / user123\n";
    }
}
