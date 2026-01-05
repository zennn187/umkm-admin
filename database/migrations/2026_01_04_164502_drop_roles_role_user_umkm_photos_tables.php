// database/migrations/[timestamp]_drop_roles_role_user_umkm_photos_tables.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Hapus tabel
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('umkm_photos');
    }

    public function down()
    {
        // Tidak perlu rollback karena ingin hapus permanen
    }
};
