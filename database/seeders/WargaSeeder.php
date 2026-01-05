<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class WargaSeeder extends Seeder
{
    public function run(): void
{
    $faker = Faker::create('id_ID');

    echo "🧹 Menghapus data lama...\n";

    // Nonaktifkan foreign key check
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('warga')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    echo "👥 Memulai seeder Warga...\n";

        // Warga 1-10 (akan menjadi pemilik UMKM)
        for ($i = 1; $i <= 10; $i++) {
            $wargaData[] = [
                'no_ktp' => '32' . str_pad($i, 14, '0', STR_PAD_LEFT),
                'name' => $faker->name(),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'pekerjaan' => 'Pengusaha UMKM',
                'telp' => '08' . $faker->numerify('##########'),
                'email' => 'warga' . $i . '@example.com',
                'alamat' => $faker->streetAddress(),
                'tanggal_lahir' => $faker->date('Y-m-d', '-25 years'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Warga 11-30 (pembeli biasa)
        for ($i = 11; $i <= 30; $i++) {
            $wargaData[] = [
                'no_ktp' => '32' . str_pad($i, 14, '0', STR_PAD_LEFT),
                'name' => $faker->name(),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'pekerjaan' => $faker->randomElement(['PNS', 'Swasta', 'Wiraswasta', 'Pelajar', 'Ibu Rumah Tangga']),
                'telp' => '08' . $faker->numerify('##########'),
                'email' => 'warga' . $i . '@example.com',
                'alamat' => $faker->streetAddress(),
                'tanggal_lahir' => $faker->date('Y-m-d', '-30 years'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('warga')->insert($wargaData);

        echo "✅ 30 data warga berhasil dibuat\n";
        echo "📊 Warga ID 1-10 sebagai pemilik UMKM\n";
        echo "📊 Warga ID 11-30 sebagai pembeli\n\n";
    }
}
