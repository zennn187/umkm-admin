<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');
            $table->string('ref_table', 100); // bukan rel_table
            $table->unsignedBigInteger('ref_id');
            $table->string('file_name', 255);
            $table->string('caption', 255)->nullable();
            $table->string('mime_type', 255);
            $table->integer('sort_order')->default(0);
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
