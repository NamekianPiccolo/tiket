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
    Schema::create('transaksis', function (Blueprint $table) {
    $table->id();
    $table->string('kode_transaksi')->unique();
    $table->unsignedBigInteger('user_id');
    $table->decimal('total_harga', 10, 2);
    $table->enum('status_pembayaran', ['menunggu', 'dibayar', 'gagal'])->default('menunggu');
    $table->string('metode_pembayaran')->nullable();
    $table->text('catatan')->nullable();
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
  
