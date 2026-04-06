<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reg_provinces', function (Blueprint $table) {
            // Menggunakan primary() tanpa increments karena ID di gambar bersifat spesifik (kode wilayah)
            $table->unsignedInteger('id')->primary();
            $table->string('name', 100);
            $table->timestamps(); // Opsional: Tambahkan jika ingin mencatat waktu created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_provinces');
    }
};
