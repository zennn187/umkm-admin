<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Umkm;
use Faker\Factory as Faker;

class UmkmSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Data dummy 22 UMKM
        for ($i = 1; $i <= 30; $i++) {
            Umkm::create([
                'nama_usaha' => $faker->company(),
                'pemilik' => $faker->name(),
                'alamat' => $faker->address(),
                'rt' => $faker->numberBetween(1, 10),
                'rw' => $faker->numberBetween(1, 10),
                'kategori' => $faker->randomElement(['Kerajinan', 'Makanan', 'Jasa', 'Pertanian', 'Teknologi']),
                'kontak' => $faker->phoneNumber(),
                'status' => $faker->randomElement(['Aktif', 'Tidak Aktif']),
                'foto' => null,
            ]);
        }

        // Data real yang Anda tambahkan manual
        Umkm::create([
            'nama_usaha' => 'Bouquet Bunga',
            'pemilik' => 'Fitri Mutia',
            'alamat' => 'JL Inti Sari, RT 2/RW 3',
            'rt' => '2',
            'rw' => '3',
            'kategori' => 'Kerajinan',
            'kontak' => '0887654567',
            'status' => 'Aktif',
            'foto' => '1763714793_22_0.jpg',
        ]);
    }
}
