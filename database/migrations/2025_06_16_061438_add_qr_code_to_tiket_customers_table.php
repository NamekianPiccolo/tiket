<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tiket_customers', function (Blueprint $table) {
            $table->string('qr_code')->nullable()->after('kode_tiket');
        });
    }

    public function down()
    {
        Schema::table('tiket_customers', function (Blueprint $table) {
            $table->dropColumn('qr_code');
        });
    }
};
