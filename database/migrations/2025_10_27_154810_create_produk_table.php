<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            // Primary key sesuai struktur: produk_id BIGINT
            $table->id('produk_id');

            // Foreign key ke tabel umkm
            $table->unsignedBigInteger('umkm_id');

            // Kolom sesuai struktur tabel
            $table->string('nama_produk', 100);
            $table->string('jenis_produk', 100)->nullable(); // TAMBAHKAN INI
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2); // DECIMAL(10,2)
            $table->integer('stok')->default(0);
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('umkm_id')
                  ->references('umkm_id') // Pastikan ini sesuai primary key di tabel umkm
                  ->on('umkm')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};
