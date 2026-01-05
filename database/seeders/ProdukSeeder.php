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

        echo "📦 Memulai seeder Produk...\n";

        // Ambil semua UMKM
        $umkmList = DB::table('umkm')->get();

        if ($umkmList->isEmpty()) {
            echo "⚠️  Tidak ada data UMKM. Jalankan UmkmSeeder terlebih dahulu...\n";
            return;
        }

        $produkData = [];

        // Produk untuk UMKM 1: Bouquet Bunga Makmur
        $produkData[] = [
            'umkm_id' => 1,
            'nama_produk' => 'Bouquet Bunga Mawar Merah',
            'jenis_produk' => 'Bunga Segar',
            'deskripsi' => 'Bouquet bunga mawar merah segar dengan kemasan eksklusif, cocok untuk hadiah spesial seperti ulang tahun, anniversary, atau wisuda.',
            'harga' => 150000,
            'stok' => 25,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $produkData[] = [
            'umkm_id' => 1,
            'nama_produk' => 'Bouquet Bunga Kering Eternal',
            'jenis_produk' => 'Bunga Kering',
            'deskripsi' => 'Bouquet bunga kering yang tahan lama hingga bertahun-tahun, tidak perlu disiram dan perawatan khusus.',
            'harga' => 250000,
            'stok' => 15,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Produk untuk UMKM 2: Toko Batik Sari Ayu
        $produkData[] = [
            'umkm_id' => 2,
            'nama_produk' => 'Batik Tulis Mega Mendung',
            'jenis_produk' => 'Pakaian',
            'deskripsi' => 'Batik tulis dengan motif mega mendung khas Cirebon, menggunakan kain katun prima dan pewarna alami.',
            'harga' => 450000,
            'stok' => 10,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $produkData[] = [
            'umkm_id' => 2,
            'nama_produk' => 'Sarung Batik Pria',
            'jenis_produk' => 'Pakaian',
            'deskripsi' => 'Sarung batik dengan motif parang rusak, cocok untuk shalat atau acara formal.',
            'harga' => 275000,
            'stok' => 20,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Produk untuk UMKM 3: Kedai Kopi Nusantara
        $produkData[] = [
            'umkm_id' => 3,
            'nama_produk' => 'Kopi Arabika Gayo',
            'jenis_produk' => 'Minuman',
            'deskripsi' => 'Kopi arabika asal Gayo, Aceh dengan cita rasa asam fruity dan aroma yang kuat.',
            'harga' => 125000,
            'stok' => 50,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $produkData[] = [
            'umkm_id' => 3,
            'nama_produk' => 'Kopi Robusta Lampung',
            'jenis_produk' => 'Minuman',
            'deskripsi' => 'Kopi robusta Lampung dengan rasa pahit khas dan kandungan kafein tinggi.',
            'harga' => 95000,
            'stok' => 40,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Produk untuk UMKM 4: Kerajinan Rotan Mandiri
        $produkData[] = [
            'umkm_id' => 4,
            'nama_produk' => 'Kursi Rotan Sofa',
            'jenis_produk' => 'Furniture',
            'deskripsi' => 'Kursi sofa rotan dengan desain modern, nyaman untuk ruang tamu.',
            'harga' => 850000,
            'stok' => 5,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $produkData[] = [
            'umkm_id' => 4,
            'nama_produk' => 'Keranjang Rotan Anyaman',
            'jenis_produk' => 'Kerajinan',
            'deskripsi' => 'Keranjang anyaman rotan untuk penyimpanan atau dekorasi rumah.',
            'harga' => 75000,
            'stok' => 30,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Produk untuk UMKM 5: Sambal Ibu Rasa
        $produkData[] = [
            'umkm_id' => 5,
            'nama_produk' => 'Sambal Terasi Pedas',
            'jenis_produk' => 'Makanan',
            'deskripsi' => 'Sambal terasi dengan level pedas tinggi, menggunakan cabai rawit pilihan dan terasi berkualitas.',
            'harga' => 35000,
            'stok' => 100,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $produkData[] = [
            'umkm_id' => 5,
            'nama_produk' => 'Sambal Matah Bali',
            'jenis_produk' => 'Makanan',
            'deskripsi' => 'Sambal matah khas Bali dengan irisan bawang merah, serai, dan daun jeruk.',
            'harga' => 40000,
            'stok' => 80,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('produk')->insert($produkData);

        echo "✅ 10 data produk berhasil dibuat\n";
        echo "📊 Setiap UMKM memiliki 2 produk terkait\n\n";
    }
}
