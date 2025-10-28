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
            $table->foreignId('warga_id')->nullable(); // FK ke tabel warga
            $table->string('customer'); // Nama customer
            $table->decimal('total', 15, 2);
            $table->enum('status', ['Baru', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'])->default('Baru');
            $table->text('alamat_kirim');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('metode_bayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
