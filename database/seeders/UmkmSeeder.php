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

        echo "🚀 Memulai seeder UMKM...\n";

        // PERBAIKAN 1: Nonaktifkan foreign key check sebelum truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('umkm')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Cek apakah ada data warga
        $wargaIds = DB::table('warga')->pluck('warga_id')->toArray();

        if (empty($wargaIds)) {
            echo "⚠️  Tidak ada data warga. Jalankan WargaSeeder terlebih dahulu...\n";
            return;
        }

        // Kategori UMKM
        $kategoriUmkm = ['Kerajinan', 'Makanan', 'Minuman', 'Jasa', 'Pertanian', 'Teknologi', 'Fashion', 'Otomotif'];

        echo "📊 Membuat 30 UMKM dummy...\n";

        // Data dummy 30 UMKM
        for ($i = 1; $i <= 30; $i++) {
            DB::table('umkm')->insert([
                'nama_usaha'        => $faker->company() . ' ' . $faker->randomElement(['Store', 'Shop', 'Mart', 'Center', 'Hub']),
                'pemilik_warga_id'  => $faker->randomElement($wargaIds),
                'alamat'            => $faker->address(),
                'rt'                => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'rw'                => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'kategori'          => $faker->randomElement($kategoriUmkm),
                'kontak'            => '08' . $faker->numerify('##########'),
                'deskripsi'         => $faker->paragraph(2),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            if ($i % 5 === 0) {
                echo "✅ $i UMKM berhasil dibuat\n";
            }
        }

        // Data real contoh
        DB::table('umkm')->insert([
            'nama_usaha'        => 'Bouquet Bunga Makmur',
            'pemilik_warga_id'  => $wargaIds[0] ?? 1,
            'alamat'            => 'JL Inti Sari No. 15, RT 2/RW 3',
            'rt'                => '02',
            'rw'                => '03',
            'kategori'          => 'Kerajinan',
            'kontak'            => '081234567890',
            'deskripsi'         => 'Usaha bouquet bunga dengan berbagai macam variasi untuk semua acara, mulai dari pernikahan, wisuda, hingga ulang tahun.',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        echo "🎉 Seeder UMKM selesai! Total 31 UMKM dibuat.\n";

        // Debug: Tampilkan jumlah UMKM
        $count = DB::table('umkm')->count();
        echo "📈 Total data UMKM di database: $count\n";
    }
}
