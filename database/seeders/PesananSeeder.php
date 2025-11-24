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

        // Ambil semua user ID
        $userIds = DB::table('users')->pluck('id')->toArray();

        for ($i = 1; $i <= 30; $i++) {
            DB::table('pesanan')->insert([
                'nomor_pesanan' => 'ORD-' . $faker->unique()->numerify('######'),
                'warga_id'      => $faker->optional()->randomElement($userIds), // <--- integer dari users
                'customer'      => $faker->name,
                'total'         => $faker->randomFloat(2, 20000, 2000000),
                'status'        => $faker->randomElement(['Baru', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan']),
                'alamat_kirim'  => $faker->address,
                'rt'            => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'rw'            => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'metode_bayar'  => $faker->randomElement(['Cash', 'Transfer', 'COD', 'QRIS']),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
