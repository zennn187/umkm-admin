<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 20; $i++) {
            DB::table('umkm')->insert([
                'nama_usaha'      => $faker->company,
                'pemilik_warga_id'=> $faker->optional()->numerify('WID###'),
                'pemilik'         => $faker->name,
                'alamat'          => $faker->address,
                'rt'              => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'rw'              => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'kategori'        => $faker->randomElement(['Kuliner', 'Jasa', 'Pakaian', 'Kerajinan', 'Pertanian']),
                'kontak'          => $faker->phoneNumber,
                'deskripsi'       => $faker->sentence(10),
                'status'          => $faker->randomElement(['Aktif', 'Nonaktif']),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
