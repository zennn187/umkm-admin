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

        echo "🏪 Memulai seeder UMKM...\n";

        // Ambil ID warga 1-10 sebagai pemilik UMKM
        $wargaIds = DB::table('warga')->whereBetween('warga_id', [1, 10])->pluck('warga_id')->toArray();

        if (empty($wargaIds)) {
            echo "⚠️  Tidak ada data warga. Jalankan WargaSeeder terlebih dahulu...\n";
            return;
        }

        // Data UMKM yang realistis dan konsisten
        $umkmData = [
            [
                'nama_usaha' => 'Bouquet Bunga Makmur',
                'pemilik_warga_id' => $wargaIds[0],
                'alamat' => 'JL Inti Sari No. 15',
                'rt' => '02',
                'rw' => '03',
                'kategori' => 'Kerajinan',
                'kontak' => '081234567890',
                'deskripsi' => 'Usaha bouquet bunga dengan berbagai macam variasi untuk semua acara, mulai dari pernikahan, wisuda, hingga ulang tahun.',
            ],
            [
                'nama_usaha' => 'Toko Batik Sari Ayu',
                'pemilik_warga_id' => $wargaIds[1],
                'alamat' => 'JL Kenanga No. 8',
                'rt' => '01',
                'rw' => '02',
                'kategori' => 'Fashion',
                'kontak' => '081234567891',
                'deskripsi' => 'Menjual berbagai macam batik tulis dan cap kualitas premium dengan motif tradisional dan modern.',
            ],
            [
                'nama_usaha' => 'Kedai Kopi Nusantara',
                'pemilik_warga_id' => $wargaIds[2],
                'alamat' => 'JL Mawar No. 20',
                'rt' => '03',
                'rw' => '04',
                'kategori' => 'Makanan & Minuman',
                'kontak' => '081234567892',
                'deskripsi' => 'Kedai kopi yang menyajikan berbagai jenis kopi lokal Indonesia dengan rasa autentik.',
            ],
            [
                'nama_usaha' => 'Kerajinan Rotan Mandiri',
                'pemilik_warga_id' => $wargaIds[3],
                'alamat' => 'JL Melati No. 5',
                'rt' => '02',
                'rw' => '05',
                'kategori' => 'Kerajinan',
                'kontak' => '081234567893',
                'deskripsi' => 'Memproduksi berbagai kerajinan dari rotan seperti kursi, meja, dan hiasan rumah.',
            ],
            [
                'nama_usaha' => 'Sambal Ibu Rasa',
                'pemilik_warga_id' => $wargaIds[4],
                'alamat' => 'JL Anggrek No. 12',
                'rt' => '04',
                'rw' => '01',
                'kategori' => 'Makanan & Minuman',
                'kontak' => '081234567894',
                'deskripsi' => 'Produksi sambal homemade dengan resep turun-temurun, menggunakan bahan-bahan segar dan alami.',
            ],
        ];

        // Tambahkan timestamps
        foreach ($umkmData as &$data) {
            $data['created_at'] = now();
            $data['updated_at'] = now();
        }

        DB::table('umkm')->insert($umkmData);

        echo "✅ 5 data UMKM berhasil dibuat\n";
        echo "📊 Setiap UMKM dimiliki oleh warga yang berbeda (ID 1-5)\n\n";
    }
}
