<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,        // ✅ HARUS PERTAMA (untuk login)
            WargaSeeder::class,        // ✅ HARUS KEDUA (relasi dengan UMKM)
            UmkmSeeder::class,         // ✅ (butuh warga)
            ProdukSeeder::class,       // ✅ (butuh UMKM)
            PesananSeeder::class,      // ✅ (butuh warga & UMKM)
            DetailPesananSeeder::class,// ✅ (butuh pesanan & produk)
        ]);
    }
}
