<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada sebelum menambah
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('alamat');
            }

            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hanya drop kolom jika ada
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
