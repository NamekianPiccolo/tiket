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
    Schema::create('detail_transaksis', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('transaksi_id');
    $table->unsignedBigInteger('tiket_id');
    $table->integer('jumlah');
    $table->decimal('harga_satuan', 10, 2);
    $table->decimal('subtotal', 10, 2);
    $table->timestamps();

    $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('cascade');
    $table->foreign('tiket_id')->references('id')->on('tikets')->onDelete('cascade');
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
