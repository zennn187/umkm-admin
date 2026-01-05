<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\UlasanProduk;
use App\Models\Produk;
use App\Models\Warga;

class UlasanProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "⭐ Memulai seeding ulasan produk...\n";

        // Hanya kosongkan jika tabel sudah ada
        if (DB::getSchemaBuilder()->hasTable('ulasan_produk')) {
            DB::table('ulasan_produk')->truncate();
            echo "🧹 Tabel ulasan_produk dibersihkan\n";
        }

        // Cek apakah data produk dan warga sudah ada
        $produkCount = Produk::count();
        $wargaCount = Warga::count();

        if ($produkCount === 0) {
            echo "⚠️  Tidak ada data produk. Jalankan ProdukSeeder terlebih dahulu!\n";
            return;
        }

        if ($wargaCount === 0) {
            echo "⚠️  Tidak ada data warga. Jalankan WargaSeeder terlebih dahulu!\n";
            return;
        }

        echo "📦 Produk tersedia: {$produkCount} data\n";
        echo "👤 Warga tersedia: {$wargaCount} data\n\n";

        // Dapatkan data produk dan warga
        $produks = Produk::where('status', 'Aktif')
                        ->where('stok', '>', 0)
                        ->get();

        $wargas = Warga::get();

        // Daftar komentar untuk ulasan
        $komentars = [
            // Rating 5 (Sangat Baik)
            'Produk ini sangat bagus! Kualitasnya melebihi ekspektasi. Pengiriman cepat dan packing aman.',
            'Sangat puas dengan pembelian ini. Produk sesuai deskripsi dan harga sangat worth it.',
            'Kualitas premium! Bahan yang digunakan sangat baik. Pasti akan beli lagi.',
            'Pelayanan penjual sangat ramah dan responsif. Produk datang tepat waktu dan dalam kondisi sempurna.',
            'Barang original, baru, dan berkualitas. Pengalaman belanja yang menyenangkan.',
            'Warna dan ukuran sesuai gambar. Sangat recommended untuk yang mencari produk berkualitas.',
            'Proses pengiriman sangat cepat. Tidak menunggu lama, barang sudah sampai.',
            'Kemasan sangat rapi dan aman. Tidak ada kerusakan sedikitpun saat sampai.',
            'Harga sangat terjangkau untuk kualitas sebaik ini. Sangat worth it!',
            'Customer service sangat membantu. Menjawab semua pertanyaan dengan sabar.',

            // Rating 4 (Baik)
            'Produk bagus, tapi pengiriman agak lama. Overall puas dengan kualitasnya.',
            'Barang sesuai deskripsi, hanya saja warna sedikit berbeda dengan foto.',
            'Kualitas baik, harga wajar. Pengiriman agak lambat karena cuaca buruk.',
            'Produknya oke, tapi ada sedikit cacat di bagian pinggir. Tidak terlalu terlihat.',
            'Size agak kecil dari yang saya kira. Tapi kualitas bahan sangat bagus.',
            'Pengiriman tepat waktu, produk sesuai. Hanya saja kemasan bisa lebih diperbaiki.',
            'Pelayanan bagus, respon cepat. Produk sesuai harapan.',
            'Overall bagus, tapi harganya sedikit mahal dibanding kompetitor.',
            'Produk berkualitas, hanya ukuran yang sedikit tidak sesuai ekspektasi.',
            'Barang bagus, packing aman. Pengiriman sedikit terlambat 1 hari.',

            // Rating 3 (Cukup)
            'Produk biasa saja, tidak sebaik yang diharapkan. Tapi masih bisa dipakai.',
            'Pengiriman lama, produk standar. Tidak ada yang spesial.',
            'Kualitas cukup, harga wajar. Sesuai untuk pemakaian sehari-hari.',
            'Size tidak sesuai dengan deskripsi. Terlalu kecil untuk ukuran yang disebutkan.',
            'Warna berbeda dengan foto. Agak mengecewakan tapi masih bisa diterima.',
            'Produk datang dengan sedikit cacat. Tapi masih bisa digunakan.',
            'Pelayanan biasa saja. Respon agak lambat untuk pertanyaan penting.',
            'Kemasan kurang aman, produk sedikit penyok. Tapi masih berfungsi normal.',
            'Harga terlalu mahal untuk kualitas yang diberikan.',
            'Produk sesuai, tapi ada beberapa bagian yang kurang rapi.',

            // Rating 2 (Buruk)
            'Produk tidak sesuai deskripsi. Kualitas jauh dari yang diharapkan.',
            'Pengiriman sangat lama, tidak ada update sama sekali.',
            'Barang rusak saat sampai. Kemasan tidak aman.',
            'Size jauh lebih kecil dari yang dijanjikan. Sangat mengecewakan.',
            'Warna sangat berbeda dengan foto. Seperti barang lain.',
            'Kualitas bahan sangat buruk. Mudah rusak.',
            'Tidak ada respon dari penjual ketika komplain.',
            'Produk second tapi dijual sebagai barang baru.',
            'Fitur tidak berfungsi seperti yang diiklankan.',
            'Pengalaman belanja yang buruk. Tidak akan beli lagi.',

            // Rating 1 (Sangat Buruk)
            'Penipuan! Barang tidak sesuai sama sekali. Uang kembali!',
            'Produk palsu, bukan original seperti yang diiklankan.',
            'Barang rusak parah, tidak bisa digunakan sama sekali.',
            'Pengiriman 2 minggu belum sampai. Penjual tidak responsif.',
            'Kualitas sangat jelek. Barang langsung rusak.',
            'Penjual tidak bertanggung jawab. Barang cacat tapi tidak bisa return.',
            'Harga mahal, kualitas sangat rendah. Sangat mengecewakan.',
            'Barang tidak sampai-sampai. Uang hangus.',
            'Layanan sangat buruk. Tidak direkomendasikan.',
            'Penipuan berkedok online shop. Hati-hati!',
        ];

        $kataTambahan = [
            'Sangat recommended!',
            'Akan beli lagi next time.',
            'Terima kasih untuk pelayanannya.',
            'Sukses terus untuk UMKM-nya!',
            'Lokasi strategis, mudah dijangkau.',
            'Produk lokal yang membanggakan.',
            'Mendukung produk dalam negeri.',
            'Kualitas ekspor!',
            'Harga bersaing dengan kualitas premium.',
            'Pelayanan ramah dan profesional.',
        ];

        $ulasans = [];
        $totalUlasan = min(100, $produkCount * 3); // Maksimal 3 ulasan per produk

        echo "📝 Membuat {$totalUlasan} data ulasan produk...\n";

        $progressBar = $this->command->getOutput()->createProgressBar($totalUlasan);

        // Membuat ulasan dengan distribusi yang lebih realistis
        for ($i = 1; $i <= $totalUlasan; $i++) {
            $produk = $produks->random();
            $warga = $wargas->random();

            // Distribusi rating: 60% rating 4-5, 25% rating 3, 10% rating 2, 5% rating 1
            $ratingRand = rand(1, 100);

            if ($ratingRand <= 60) {
                $rating = rand(4, 5);
            } elseif ($ratingRand <= 85) {
                $rating = 3;
            } elseif ($ratingRand <= 95) {
                $rating = 2;
            } else {
                $rating = 1;
            }

            // Pilih komentar berdasarkan rating
            $komentarIndex = ($rating - 1) * 10 + rand(0, 9);
            $komentar = $komentars[$komentarIndex] ?? $komentars[0];

            // Tambahkan kata tambahan untuk rating baik
            if ($rating >= 4 && rand(1, 100) <= 30) {
                $komentar .= ' ' . $kataTambahan[rand(0, count($kataTambahan) - 1)];
            }

            // Tambahkan nama produk dalam komentar untuk rating baik
            if ($rating >= 4 && rand(1, 100) <= 40) {
                $komentar .= " {$produk->nama_produk} memang juara!";
            }

            $isVerified = rand(1, 100) <= 20; // 20% terverifikasi
            $isVisible = rand(1, 100) <= 95; // 95% terlihat

            // Tanggal dibuat (dalam 3 bulan terakhir)
            $createdAt = now()->subDays(rand(0, 90))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $updatedAt = $createdAt->copy()->addDays(rand(0, 3))->addHours(rand(0, 12));

            $ulasans[] = [
                'produk_id' => $produk->produk_id,
                'warga_id' => $warga->warga_id,
                'rating' => $rating,
                'komentar' => $komentar,
                'is_verified' => $isVerified,
                'is_visible' => $isVisible,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ];

            // Insert batch setiap 50 data
            if ($i % 50 === 0 || $i === $totalUlasan) {
                UlasanProduk::insert($ulasans);
                $ulasans = [];
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        echo "\n\n";

        // Tampilkan statistik
        $totalData = UlasanProduk::count();
        $avgRating = UlasanProduk::avg('rating');
        $verifiedCount = UlasanProduk::where('is_verified', true)->count();
        $visibleCount = UlasanProduk::where('is_visible', true)->count();

        echo "📊 STATISTIK ULASAN PRODUK:\n";
        echo str_repeat("=", 40) . "\n";
        echo "• Total Ulasan: {$totalData}\n";
        echo "• Rata-rata Rating: " . number_format($avgRating, 2) . "/5\n";
        echo "• Ulasan Terverifikasi: {$verifiedCount}\n";
        echo "• Ulasan Terlihat: {$visibleCount}\n\n";

        echo "📈 DISTRIBUSI RATING:\n";
        for ($r = 5; $r >= 1; $r--) {
            $count = UlasanProduk::where('rating', $r)->count();
            $percentage = $totalData > 0 ? ($count / $totalData) * 100 : 0;
            $stars = str_repeat('★', $r) . str_repeat('☆', 5 - $r);
            $bar = str_repeat('█', round($percentage / 5));
            echo "  {$stars} ({$r}/5): {$count} ulasan " . str_pad(number_format($percentage, 1) . "%", 7) . " {$bar}\n";
        }

        echo "\n✅ Seeding ulasan produk selesai!\n";
    }
}
