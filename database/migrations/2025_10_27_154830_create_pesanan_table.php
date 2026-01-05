<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('pesanan_id');
            $table->string('nomor_pesanan')->unique();

            // PERBAIKAN: Sesuaikan dengan struktur warga yang ada
            $table->unsignedBigInteger('warga_id')->nullable();
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('set null');

            $table->unsignedBigInteger('umkm_id')->nullable();
            $table->foreign('umkm_id')->references('umkm_id')->on('umkm')->onDelete('set null');

            $table->decimal('total', 15, 2);
            $table->enum('status', ['Baru', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'])->default('Baru');
            $table->text('alamat_kirim');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('metode_bayar');
            $table->string('bukti_bayar', 255)->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['warga_id', 'umkm_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
