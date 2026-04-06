<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reg_regencies', function (Blueprint $table) {
            // ID menggunakan integer karena di gambar berupa kode (1101, 1102, dst)
            $table->unsignedInteger('id')->primary();

            // Relasi ke tabel provinsi
            $table->unsignedInteger('province_id');

            $table->string('name', 150);
            $table->timestamps();

            // Set Foreign Key agar data konsisten
            $table->foreign('province_id')
                  ->references('id')
                  ->on('reg_provinces')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reg_regencies');
    }
};
