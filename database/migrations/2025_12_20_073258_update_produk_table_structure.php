<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('produk', function (Blueprint $table) {
            // Ubah nama kolom jika perlu
            if (Schema::hasColumn('produk', 'kategori')) {
                $table->renameColumn('kategori', 'jenis_produk');
            }

            // Ubah tipe data kolom
            $table->string('jenis_produk', 100)->nullable()->change();

            // Hapus kolom yang tidak perlu
            if (Schema::hasColumn('produk', 'gambar')) {
                $table->dropColumn('gambar');
            }
            if (Schema::hasColumn('produk', 'is_active')) {
                $table->dropColumn('is_active');
            }

            // Tambah kolom yang belum ada
            if (!Schema::hasColumn('produk', 'status')) {
                $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            }

            // Ubah default nilai
            $table->integer('stok')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('produk', function (Blueprint $table) {
            // Revert changes
            $table->renameColumn('jenis_produk', 'kategori');
            $table->dropColumn('status');
        });
    }
};
