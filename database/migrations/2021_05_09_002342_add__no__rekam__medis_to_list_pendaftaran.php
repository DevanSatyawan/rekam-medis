<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoRekamMedisToListPendaftaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('list_pendaftaran', function (Blueprint $table) {
            $table->unsignedBigInteger('No_Rekam_Medis')->after('id');
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
        Schema::table('list_pendaftaran', function (Blueprint $table) {
            $table->dropColumn('No_Rekam_Medis');
        });
    }
}
