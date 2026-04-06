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
         Schema::create('tikets', function (Blueprint $table) {
        $table->id();
        $table->string('namaTiket');
        $table->decimal('harga');
        $table->integer('stok');
        $table->string('lokawebsi'); // koordinat atau alamat
        $table->string('gambar')->nullable(); // nama file gambar
        $table->text('deskripsi');
        $table->char('regencie_id', 4)->nullable();
        $table->date('tanggal_pelaksanaan'); // tambahan field tanggal pelaksanaan
        $table->enum('status', ['tidak tersedia', 'tersedia'])->default('tersedia'); // tambahan field status
        $table->date('tanggal_selesai_pelaksanaan')->nullable(); // tanggal selesai pelaksanaan (nullable jika event satu hari)
        $table->time('waktu_mulai')->nullable(); // waktu mulai pelaksanaan
        $table->time('waktu_selesai')->nullable(); // waktu selesai pelaksanaan
        $table->timestamps();
         });

         }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
