<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tikets', function (Blueprint $table) {
            // Tambahkan kolom tanggal_pelaksanaan (DATE)

            
        });
    }

    public function down()
    {
        Schema::table('tikets', function (Blueprint $table) {
            // Hapus kolom jika migration di-rollback
            $table->dropColumn(['tanggal_pelaksanaan', 'status']);
        });
    }
};
