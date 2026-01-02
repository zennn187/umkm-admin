<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus kolom customer jika ada
        if (Schema::hasColumn('pesanan', 'customer')) {
            Schema::table('pesanan', function (Blueprint $table) {
                $table->dropColumn('customer');
            });
        }

        // 2. Tambah kolom umkm_id jika belum ada
        if (!Schema::hasColumn('pesanan', 'umkm_id')) {
            Schema::table('pesanan', function (Blueprint $table) {
                $table->unsignedBigInteger('umkm_id')->nullable()->after('warga_id');
            });
        }

        // 3. Tambah kolom bukti_bayar jika belum ada
        if (!Schema::hasColumn('pesanan', 'bukti_bayar')) {
            Schema::table('pesanan', function (Blueprint $table) {
                $table->string('bukti_bayar', 255)->nullable()->after('metode_bayar');
            });
        }

        // 4. Tambah foreign key constraint untuk umkm_id
        // Cek dulu apakah sudah ada foreign key
        Schema::table('pesanan', function (Blueprint $table) {
            // Gunakan try-catch untuk aman
            try {
                $table->foreign('umkm_id')
                    ->references('umkm_id')
                    ->on('umkm')
                    ->onDelete('set null');
            } catch (\Exception $e) {
                // Foreign key mungkin sudah ada, skip saja
            }
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Drop foreign key
            try {
                $table->dropForeign(['umkm_id']);
            } catch (\Exception $e) {
                try {
                    $table->dropForeign('pesanan_umkm_id_foreign');
                } catch (\Exception $e) {
                    // Skip jika tidak ada
                }
            }

            // Drop kolom
            if (Schema::hasColumn('pesanan', 'umkm_id')) {
                $table->dropColumn('umkm_id');
            }

            if (Schema::hasColumn('pesanan', 'bukti_bayar')) {
                $table->dropColumn('bukti_bayar');
            }

            // Tambah kembali customer
            if (!Schema::hasColumn('pesanan', 'customer')) {
                $table->string('customer', 255)->nullable();
            }
        });
    }
};
