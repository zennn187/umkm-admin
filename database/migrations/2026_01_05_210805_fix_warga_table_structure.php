<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Pastikan kolom warga_id adalah BIGINT UNSIGNED
        Schema::table('warga', function (Blueprint $table) {
            // Ubah tipe data warga_id jika perlu
            $table->bigIncrements('warga_id')->change();
        });
    }

    public function down()
    {
        // Tidak perlu down migration untuk perbaikan ini
    }
};
