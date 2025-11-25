<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_photos', function (Blueprint $table) {
            $table->id('photo_id');
            $table->foreignId('umkm_id')->constrained('umkm', 'umkm_id')->onDelete('cascade');
            $table->string('photo_path');
            $table->string('photo_name');
            $table->integer('order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_photos');
    }
};
