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

        // Ambil semua id umkm agar FK valid
        $umkmIds = DB::table('umkm')->pluck('umkm_id')->toArray();

        // Jika belum ada UMKM, hentikan seeding
        if (empty($umkmIds)) {
            echo "⚠️  Tidak ada data UMKM. Seeder produk dilewati.\n";
            return;
        }

        // Data jenis produk yang mungkin
        $jenisProduk = [
            'Makanan', 'Minuman', 'Pakaian', 'Kerajinan', 'Elektronik',
            'Pertanian', 'Jasa', 'Kecantikan', 'Otomotif', 'Perhiasan'
        ];

        // Status sesuai migration (ENUM: 'Aktif', 'Nonaktif')
        $statusProduk = ['Aktif', 'Nonaktif'];

        // Data dummy 30 produk
        for ($i = 1; $i <= 30; $i++) {
            DB::table('produk')->insert([
                'umkm_id'       => $faker->randomElement($umkmIds),
                'nama_produk'   => $faker->words(3, true) . ' ' . $faker->randomElement(['Premium', 'Original', 'Special']),
                'jenis_produk'  => $faker->randomElement($jenisProduk), // TAMBAHKAN INI
                'deskripsi'     => $faker->paragraph(3),
                'harga'         => $faker->randomFloat(2, 5000, 500000),
                'stok'          => $faker->numberBetween(0, 100),
                'status'        => $faker->randomElement($statusProduk), // SESUAI MIGRATION
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            echo "✅ Produk ke-$i berhasil dibuat\n";
        }

        echo "🎉 Seeder produk selesai! Total 30 produk dibuat.\n";
    }
}
