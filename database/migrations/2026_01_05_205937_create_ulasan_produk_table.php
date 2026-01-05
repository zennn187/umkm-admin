<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('ulasan_produk', function (Blueprint $table) {
        $table->id('ulasan_id');
        $table->unsignedBigInteger('produk_id');

        // ⚠️ PASTIKAN: Gunakan unsignedBigInteger karena warga_id adalah BIGINT
        $table->unsignedBigInteger('warga_id');

        $table->tinyInteger('rating')->default(1)->comment('1-5');
        $table->text('komentar');
        $table->boolean('is_verified')->default(false);
        $table->boolean('is_visible')->default(true);
        $table->timestamps();

        // Foreign keys
        $table->foreign('produk_id')
              ->references('produk_id')
              ->on('produk')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->foreign('warga_id')
              ->references('warga_id') // Pastikan ini match dengan primaryKey di model Warga
              ->on('warga')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        // Indexes
        $table->index('produk_id');
        $table->index('warga_id');
        $table->index('rating');
        $table->index('created_at');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ulasan_produk');
    }
};
