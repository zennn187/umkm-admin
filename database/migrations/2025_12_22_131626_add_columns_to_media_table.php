<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Tambah kolom baru
            $table->string('alt_text', 255)->nullable()->after('caption');
            $table->string('title', 255)->nullable()->after('alt_text');



            // Hapus kolom (hati-hati!)
            // $table->dropColumn('nama_kolom');
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'title']);
            $table->string('file_path', 500)->change();
        });
    }
};
