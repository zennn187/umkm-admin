<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Cek apakah kolom role ada
        if (Schema::hasColumn('users', 'role')) {
            // Ubah tipe kolom menjadi enum dengan nilai yang benar
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user', 'mitra') NOT NULL DEFAULT 'user'");

            // Update data yang tidak valid
            DB::table('users')
                ->whereNotIn('role', ['admin', 'user', 'mitra'])
                ->update(['role' => 'user']);
        } else {
            // Jika tidak ada, tambahkan
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'user', 'mitra'])
                    ->default('user')
                    ->after('password');
            });
        }

        // Pastikan semua user punya role
        DB::table('users')->whereNull('role')->update(['role' => 'user']);
    }

    public function down()
    {
        // Tidak perlu down migration untuk fix
    }
};
