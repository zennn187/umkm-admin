<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddRoleToUsersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                // Gunakan string untuk kompatibilitas MySQL versi lama
                $table->string('role', 10)->default('user')->after('email');
            });

            // Update nilai enum secara manual
            DB::statement("ALTER TABLE users
                MODIFY COLUMN role ENUM('admin', 'user', 'mitra')
                DEFAULT 'user' NOT NULL");
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
