<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // ambil semua id umkm agar fk valid
        $umkmIds = DB::table('umkm')->pluck('umkm_id')->toArray();

        // jika belum ada UMKM, hentikan seeding
        if (empty($umkmIds)) {
            return;
        }

        for ($i = 1; $i <= 30; $i++) {
            DB::table('produk')->insert([
                'umkm_id'       => $faker->randomElement($umkmIds),
                'nama_produk'   => $faker->words(3, true),
                'deskripsi'     => $faker->sentence(12),
                'harga'         => $faker->randomFloat(2, 5000, 500000),
                'stok'          => $faker->numberBetween(0, 100),
                'status'        => $faker->randomElement(['Tersedia', 'Habis', 'Preorder']),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
