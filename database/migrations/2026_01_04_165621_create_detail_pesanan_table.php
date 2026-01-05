// database/migrations/[timestamp]_create_detail_pesanan_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            // Primary key
            $table->id('detail_pesanan_id');

            // Foreign key ke tabel pesanan
            $table->foreignId('pesanan_id')
                  ->constrained('pesanan', 'pesanan_id')
                  ->onDelete('cascade');

            // Foreign key ke tabel produk
            $table->foreignId('produk_id')
                  ->constrained('produk', 'produk_id')
                  ->onDelete('cascade');

            // Kolom utama
            $table->integer('quantity')->default(1);
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);

            // Timestamps
            $table->timestamps();

            // Indexes untuk performa
            $table->index(['pesanan_id', 'produk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
