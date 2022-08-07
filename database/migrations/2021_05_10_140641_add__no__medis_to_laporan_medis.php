<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoMedisToLaporanMedis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_medis', function (Blueprint $table) {
            $table->foreign('No_Rekam_Medis')->references('No_Medis')->on('data_pasien')
            ->onUpdate('CASCADE')
            ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_medis', function (Blueprint $table) {
            $table->dropColumn('No_Rekam_Medis');
        });
    }
}
