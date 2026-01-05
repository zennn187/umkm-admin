<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DetailPesananSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        echo "🛍️  Memulai seeder Detail Pesanan...\n";

        // Cek apakah tabel detail_pesanan ada
        if (!DB::getSchemaBuilder()->hasTable('detail_pesanan')) {
            echo "⚠️  Tabel 'detail_pesanan' tidak ditemukan. Buat migration terlebih dahulu.\n";
            return;
        }

        // Ambil semua pesanan
        $pesananList = DB::table('pesanan')->get();

        // Ambil semua produk dengan stok > 0
        $produkList = DB::table('produk')->where('stok', '>', 0)->get();

        if ($pesananList->isEmpty() || $produkList->isEmpty()) {
            echo "⚠️  Tidak ada data pesanan atau produk. Jalankan PesananSeeder dan ProdukSeeder terlebih dahulu...\n";
            return;
        }

        echo "📊 Jumlah pesanan: " . $pesananList->count() . "\n";
        echo "📊 Jumlah produk tersedia: " . $produkList->count() . "\n";

        $detailPesananData = [];
        $counter = 0;
        $pesananDilewati = 0;

        foreach ($pesananList as $pesanan) {
            // Cari produk yang sesuai dengan UMKM pesanan ini
            $produkUntukUmkm = $produkList->where('umkm_id', $pesanan->umkm_id);

            // Jika tidak ada produk untuk UMKM ini, skip pesanan ini
            if ($produkUntukUmkm->isEmpty()) {
                echo "⚠️  Tidak ada produk untuk UMKM ID {$pesanan->umkm_id}. Pesanan ID {$pesanan->pesanan_id} dilewati.\n";
                $pesananDilewati++;
                continue;
            }

            // Tentukan berapa banyak produk dalam satu pesanan (1-3 produk, tapi tidak lebih dari jumlah produk tersedia)
            $maxProduk = min(3, $produkUntukUmkm->count());
            $jumlahProduk = $faker->numberBetween(1, $maxProduk);

            $produkTerpilih = [];
            $totalPesanan = 0;

            // Pilih produk secara acak dari produk yang tersedia untuk UMKM ini
            for ($i = 0; $i < $jumlahProduk; $i++) {
                // Ambil produk yang belum dipilih
                $availableProduks = $produkUntukUmkm->whereNotIn('produk_id', $produkTerpilih);

                if ($availableProduks->isEmpty()) {
                    break; // Tidak ada produk lain untuk dipilih
                }

                $produk = $availableProduks->random();
                $produkTerpilih[] = $produk->produk_id;

                // Quantity maksimal sesuai stok
                $maxQuantity = min(3, $produk->stok);
                $quantity = $faker->numberBetween(1, $maxQuantity);
                $subtotal = $produk->harga * $quantity;
                $totalPesanan += $subtotal;

                $detailPesananData[] = [
                    'pesanan_id' => $pesanan->pesanan_id,
                    'produk_id' => $produk->produk_id,
                    'quantity' => $quantity,
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $subtotal,
                    'created_at' => $pesanan->created_at,
                    'updated_at' => now(),
                ];

                $counter++;
            }

            // Update total pesanan di tabel pesanan
            if ($totalPesanan > 0) {
                DB::table('pesanan')
                    ->where('pesanan_id', $pesanan->pesanan_id)
                    ->update(['total' => $totalPesanan]);

                echo "✅ Detail pesanan untuk Pesanan ID {$pesanan->pesanan_id} berhasil dibuat (Total: Rp " . number_format($totalPesanan, 0, ',', '.') . ")\n";
            }
        }

        // Insert data detail pesanan
        if (!empty($detailPesananData)) {
            DB::table('detail_pesanan')->insert($detailPesananData);

            echo "\n🎉 {$counter} data detail pesanan berhasil dibuat\n";
            echo "📊 Rata-rata " . round($counter / ($pesananList->count() - $pesananDilewati), 1) . " produk per pesanan\n";
            if ($pesananDilewati > 0) {
                echo "⚠️  {$pesananDilewati} pesanan dilewati karena tidak ada produk untuk UMKM\n";
            }
        } else {
            echo "⚠️  Tidak ada detail pesanan yang bisa dibuat\n";
        }
    }
}
