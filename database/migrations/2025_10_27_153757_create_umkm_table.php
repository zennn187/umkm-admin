<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('umkm', function (Blueprint $table) {
    $table->id('umkm_id'); // otomatis bigint unsigned auto_increment
    $table->string('nama_usaha');
    $table->unsignedInteger('pemilik_warga_id'); // HAPUS auto_increment dari sini
    $table->text('alamat');
    $table->string('rt', 3);
    $table->string('rw', 3);
    $table->string('kategori');
    $table->string('kontak');
    $table->text('deskripsi')->nullable();
    $table->timestamps();

            // Optional: tambahkan foreign key constraint
            // $table->foreign('pemilik_warga_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('umkm');
    }
};

