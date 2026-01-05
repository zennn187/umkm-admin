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

        DB::table('users')->truncate();

        echo "🧹 Tabel users dibersihkan\n\n";

        // 1. User ADMIN (penting untuk login)
        DB::table('users')->insert([
            'name' => 'Oza Admin',
            'email' => 'ozaadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ozaadmin123'),
            'alamat' => 'Budi Sari',
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Admin user dibuat: ozaadmin@gmail.com / ozaadmin123\n";

        // 2. User mitra (pemilik UMKM)
        // User mitra utama
        DB::table('users')->insert([
            'name' => 'Oza Mitra',
            'email' => 'ozamitra@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ozamitra123'),
            'alamat' => 'Jl. Warga No. 1',
            'role' => 'mitra',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Mitra user dibuat: ozamitra@gmail.com / ozamitra123\n";

        // User mitra tambahan
        for ($i = 1; $i <= 9; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => 'mitra' . $i . '@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'alamat' => $faker->address(),
                'role' => 'mitra',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            echo "📝 Mitra user {$i} dibuat: mitra{$i}@gmail.com / password\n";
        }

        // 3. User BIASA (pembeli)
        DB::table('users')->insert([
            'name' => 'Oza User',
            'email' => 'ozauser@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ozauser123'),
            'alamat' => 'Jl. User No. 1',
            'role' => 'user',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ User biasa dibuat: ozauser@gmail.com / ozauser123\n";

        // User biasa tambahan
        for ($i = 1; $i <= 19; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => 'user' . $i . '@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'alamat' => $faker->address(),
                'role' => 'user',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if ($i % 5 == 0) {
                echo "📝 User biasa {$i} dibuat\n";
            }
        }

        $totalUsers = DB::table('users')->count();

        echo "\n🎉 Seeder users selesai! Total {$totalUsers} user dibuat.\n";

        echo "\n📋 LOGIN INFO:\n";
        echo str_repeat("=", 40) . "\n";
        echo "ADMIN:\n";
        echo "  Email: ozaadmin@gmail.com\n";
        echo "  Password: ozaadmin123\n";
        echo "  Role: admin\n\n";

        echo "MITRA (Pemilik UMKM):\n";
        echo "  Email: ozamitra@gmail.com\n";
        echo "  Password: ozamitra123\n";
        echo "  Role: mitra\n\n";

        echo "USER (Pembeli):\n";
        echo "  Email: ozauser@gmail.com\n";
        echo "  Password: ozauser123\n";
        echo "  Role: user\n";
        echo str_repeat("=", 40) . "\n\n";

        // Tampilkan statistik
        $this->showUserStats();
    }

    /**
     * Tampilkan statistik user
     */
    private function showUserStats(): void
    {
        $stats = DB::table('users')
            ->select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        echo "📊 STATISTIK USER:\n";
        echo str_repeat("-", 30) . "\n";

        foreach ($stats as $role => $total) {
            echo sprintf("  %-10s: %2d user\n", ucfirst($role), $total);
        }

        echo "\n";
    }
}
