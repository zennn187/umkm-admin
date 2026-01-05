<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        echo "🎬 MEMULAI SEEDING DATABASE TERINTEGRASI\n";
        echo str_repeat("=", 50) . "\n\n";

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'ulasan_produk',
            'detail_pesanan',
            'pesanan',
            'produk',
            'umkm',
            'warga',
            'users',
        ];

        echo "🧹 MEMBERSIHKAN TABEL:\n";
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                echo "  • {$table}... ";
                DB::table($table)->truncate();
                echo "✅\n";
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "\n✅ SEMUA TABEL TELAH DIBERSIHKAN\n\n";

        $seeders = [
            // 1. Data master
            UsersSeeder::class,
            WargaSeeder::class,

            // 2. Data UMKM & Produk
            UmkmSeeder::class,
            ProdukSeeder::class,

            // 3. Data transaksi
            PesananSeeder::class,
            DetailPesananSeeder::class,

            UlasanProdukSeeder::class,
        ];

        echo "🚀 MENJALANKAN SEEDER:\n";
        echo str_repeat("-", 50) . "\n";

        foreach ($seeders as $seederClass) {
            $seederName = class_basename($seederClass);
            echo "▶️  Menjalankan {$seederName}...\n";

            $startTime = microtime(true);
            $this->call($seederClass);
            $endTime = microtime(true);

            $executionTime = round(($endTime - $startTime) * 1000, 2);
            echo "   ⏱️  Selesai dalam {$executionTime}ms\n\n";
        }

        echo str_repeat("=", 50) . "\n";
        echo "🎉 SEMUA SEEDER BERHASIL DIJALANKAN!\n";
        echo "📊 Data siap digunakan untuk pengembangan.\n\n";

        $this->showDatabaseSummary();
    }

    /**
     * Menampilkan ringkasan data di database
     */
    private function showDatabaseSummary(): void
    {
        echo "📈 RINGKASAN DATA:\n";
        echo str_repeat("-", 40) . "\n";

        $tablesToCheck = ['users', 'warga', 'umkm', 'produk', 'pesanan', 'detail_pesanan', 'ulasan_produk'];

        foreach ($tablesToCheck as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                echo sprintf("  • %-15s: %4d data\n", ucfirst($table), $count);
            }
        }

        if (Schema::hasTable('ulasan_produk')) {
            $avgRating = DB::table('ulasan_produk')->avg('rating');
            $verifiedCount = DB::table('ulasan_produk')->where('is_verified', true)->count();
            echo "\n  ⭐ Rata-rata Rating: " . number_format($avgRating, 2) . "/5\n";
            echo "  ✅ Ulasan Terverifikasi: {$verifiedCount}\n";
        }

        echo "\n";
    }
}
