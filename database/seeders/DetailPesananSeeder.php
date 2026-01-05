<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;

class DetailPesananSeeder extends Seeder
{
    public function run(): void
    {
        echo "🚀 Memulai seeder detail pesanan...\n";

    // Ambil beberapa pesanan dan produk
    $pesanans = Pesanan::take(10)->get(); // ambil 10, bukan 5
    $produks = Produk::where('stok', '>', 0)->take(20)->get(); // produk dengan stok

    if ($pesanans->isEmpty() || $produks->isEmpty()) {
        echo "⚠️  Tidak ada data pesanan atau produk. Seeder dilewati.\n";
        return;
    }

        foreach ($pesanans as $pesanan) {
            // Buat 1-3 detail pesanan per pesanan
            $jumlahDetail = rand(1, 3);

            for ($i = 0; $i < $jumlahDetail; $i++) {
                $produk = $produks->random();
                $quantity = rand(1, 5);
                $hargaSatuan = $produk->harga;
                $subtotal = $quantity * $hargaSatuan;

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'produk_id' => $produk->produk_id,
                    'quantity' => $quantity,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal
                ]);
            }
        }
    }
}
