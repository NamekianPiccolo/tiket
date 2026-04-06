<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tiket_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained()->onDelete('cascade');
            $table->foreignId('tiket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode_tiket')->unique();
            $table->string('nama');
            $table->string('email');
            $table->enum('status', ['aktif', 'digunakan', 'kadaluarsa'])->default('aktif');
            $table->dateTime('tanggal_pembelian');
            $table->dateTime('tanggal_expired')->nullable();
            $table->text('qr_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiket_customers');
    }
};
