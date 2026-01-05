<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        echo "🛒 Memulai seeder Pesanan...\n";

        // Ambil data warga (pembeli)
        $pembeliIds = DB::table('warga')->whereBetween('warga_id', [11, 30])->pluck('warga_id')->toArray();

        // Ambil data UMKM
        $umkmIds = DB::table('umkm')->pluck('umkm_id')->toArray();

        // Ambil data produk
        $produkList = DB::table('produk')->get();

        if (empty($pembeliIds) || empty($umkmIds) || $produkList->isEmpty()) {
            echo "⚠️  Data tidak lengkap. Pastikan semua seeder sudah dijalankan...\n";
            return;
        }

        $pesananData = [];

        // Buat 10 pesanan
        for ($i = 1; $i <= 10; $i++) {
            // Pilih pembeli dan UMKM secara acak
            $pembeliId = $faker->randomElement($pembeliIds);
            $umkmId = $faker->randomElement($umkmIds);

            // Pilih produk dari UMKM yang dipilih
            $produkUmkm = $produkList->where('umkm_id', $umkmId)->random();

            // Hitung total (produk harga * quantity)
            $quantity = $faker->numberBetween(1, 3);
            $total = $produkUmkm->harga * $quantity;

            $pesananData[] = [
                'nomor_pesanan' => 'ORD' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'warga_id' => $pembeliId,
                'umkm_id' => $umkmId,
                'total' => $total,
                'status' => $faker->randomElement(['Baru', 'Diproses', 'Dikirim', 'Selesai']),
                'alamat_kirim' => $faker->streetAddress(),
                'rt' => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'rw' => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'metode_bayar' => $faker->randomElement(['Transfer Bank', 'COD', 'E-Wallet']),
                'bukti_bayar' => $faker->optional()->imageUrl(),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                'updated_at' => now(),
            ];
        }

        DB::table('pesanan')->insert($pesananData);

        echo "✅ 10 data pesanan berhasil dibuat\n";
        echo "📊 Pesanan dibuat oleh warga ID 11-30\n";
        echo "📊 Setiap pesanan terkait dengan UMKM tertentu\n";
        echo "📊 Total pesanan dihitung berdasarkan harga produk\n\n";
    }
}
