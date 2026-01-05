<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        echo "👨‍👩‍👧‍👦 Memulai seeder warga...\n";

        // ✅ PERBAIKAN: Nonaktifkan foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('warga')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Reset auto increment
        DB::statement('ALTER TABLE warga AUTO_INCREMENT = 1');

        echo "📊 Membuat 20 data warga dummy...\n";

        for ($i = 1; $i <= 20; $i++) {
            DB::table('warga')->insert([
                'no_ktp'        => $faker->unique()->numerify('################'),
                'name'          => $faker->name(),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'pekerjaan'     => $faker->jobTitle(),
                'telp'          => '08' . $faker->numerify('##########'),
                'email'         => $faker->unique()->safeEmail(),
                'alamat'        => $faker->address(),
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            if ($i % 5 === 0) {
                echo "✅ $i warga berhasil dibuat\n";
            }
        }

        echo "🎉 Seeder warga selesai! Total 20 warga dibuat.\n";
    }
}
