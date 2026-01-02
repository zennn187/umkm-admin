<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // CEK DULU apakah tabel sudah ada
        if (!Schema::hasTable('umkm_photos')) {
            Schema::create('umkm_photos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('umkm_id');
                $table->string('photo_path');
                $table->timestamps();

                // Pastikan foreign key sesuai dengan struktur tabel umkm
                // Jika di tabel umkm primary key-nya 'umkm_id', maka OK
                // Jika primary key-nya 'id', maka ganti jadi 'id'
                $table->foreign('umkm_id')
                      ->references('umkm_id')  // atau 'id' tergantung struktur
                      ->on('umkm')
                      ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_photos');
    }
};
