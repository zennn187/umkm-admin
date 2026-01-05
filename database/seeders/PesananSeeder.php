<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        echo "🚀 Memulai seeder pesanan...\n";

        // PERBAIKAN: Nonaktifkan foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pesanan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil data warga lengkap (bukan hanya ID)
        $wargas = DB::table('warga')
            ->select('warga_id', 'alamat', 'name')
            ->get()
            ->keyBy('warga_id')
            ->toArray();

        // Ambil data umkm lengkap - PERBAIKAN: Pastikan kolumnya benar
        $umkms = DB::table('umkm')
            ->select('umkm_id', 'nama_usaha')  // PERBAIKAN: nama_usaha sesuai migration
            ->get()
            ->keyBy('umkm_id')
            ->toArray();

        // Debug: Cek apa yang didapat
        echo "👥 Jumlah warga: " . count($wargas) . "\n";
        echo "🏪 Jumlah UMKM: " . count($umkms) . "\n";

        // Cek apakah ada data warga dan umkm
        if (empty($wargas)) {
            echo "❌ ERROR: Tidak ada data warga. Jalankan WargaSeeder terlebih dahulu!\n";
            return;
        }

        if (empty($umkms)) {
            echo "❌ ERROR: Tidak ada data UMKM. Jalankan UmkmSeeder terlebih dahulu!\n";
            return;
        }

        // Metode bayar
        $metodeBayar = ['Cash', 'Transfer Bank', 'E-Wallet', 'COD', 'QRIS'];

        // Status pesanan dengan distribusi lebih realistis
        $statusPesanan = [
            'Baru' => 0.25,        // 25%
            'Diproses' => 0.30,    // 30%
            'Dikirim' => 0.20,     // 20%
            'Selesai' => 0.20,     // 20%
            'Dibatalkan' => 0.05,  // 5%
        ];

        echo "📦 Membuat 30 pesanan dummy...\n";

        // Data dummy 30 pesanan
        for ($i = 1; $i <= 30; $i++) {
            // Pilih warga dan umkm secara acak
            $wargaId = array_rand($wargas);
            $umkmId = array_rand($umkms);

            $warga = $wargas[$wargaId];
            $umkm = $umkms[$umkmId];

            // Generate nomor pesanan unik dengan format ORD-YYYYMMDD-XXXX
            $createdAt = Carbon::now()->subDays(rand(0, 60));
            $datePrefix = $createdAt->format('Ymd');
            $sequence = str_pad($i, 4, '0', STR_PAD_LEFT);
            $nomorPesanan = 'ORD-' . $datePrefix . '-' . $sequence;

            // Pilih status dengan distribusi
            $status = $this->getWeightedRandomStatus($statusPesanan);

            // Hitung total yang lebih realistis (kelipatan 1000)
            $total = round($faker->randomFloat(2, 50000, 2000000) / 1000) * 1000;

            // Tentukan bukti bayar berdasarkan status
            $buktiBayar = null;
            if (in_array($status, ['Diproses', 'Dikirim', 'Selesai'])) {
                $buktiBayar = 'bukti_bayar_' . $faker->uuid() . '.jpg';
            }

            DB::table('pesanan')->insert([
                'nomor_pesanan' => $nomorPesanan,
                'warga_id'      => $wargaId,
                'umkm_id'       => $umkmId,
                'total'         => $total,
                'status'        => $status,
                'alamat_kirim'  => $warga->alamat ?? $faker->address(),
                'rt'            => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'rw'            => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'metode_bayar'  => $faker->randomElement($metodeBayar),
                'bukti_bayar'   => $buktiBayar,
                'created_at'    => $createdAt,
                'updated_at'    => $this->generateUpdatedAt($createdAt, $status),
            ]);

            if ($i % 5 === 0) {
                echo "✅ $i pesanan berhasil dibuat\n";
            }
        }

        echo "🎉 Seeder pesanan selesai! Total 30 pesanan dibuat.\n";

        // Tampilkan distribusi status
        echo "📊 Distribusi status pesanan:\n";
        $this->showStatusDistribution();
    }

    /**
     * Pilih status dengan bobot
     */
    private function getWeightedRandomStatus($statusWeights): string
    {
        $rand = mt_rand() / mt_getrandmax();
        $cumulative = 0;

        foreach ($statusWeights as $status => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $status;
            }
        }

        return 'Baru';
    }

    /**
     * Generate updated_at berdasarkan status
     */
    private function generateUpdatedAt(Carbon $createdAt, string $status): Carbon
    {
        $daysToAdd = match($status) {
            'Baru' => rand(0, 1),
            'Diproses' => rand(1, 3),
            'Dikirim' => rand(3, 7),
            'Selesai' => rand(7, 14),
            'Dibatalkan' => rand(1, 2),
            default => 0,
        };

        return $createdAt->copy()->addDays($daysToAdd);
    }

    /**
     * Tampilkan distribusi status setelah seeding
     */
    private function showStatusDistribution(): void
    {
        $distribusi = DB::table('pesanan')
            ->select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('jumlah', 'status')
            ->toArray();

        foreach ($distribusi as $status => $jumlah) {
            echo "   - $status: $jumlah pesanan\n";
        }
    }
}
