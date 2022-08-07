<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanMedis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_medis', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->bigInteger('No_Rekam_Medis')->unsigned();
            $table->string('Nama')->nullable();
            $table->string('Umur')->nullable();
            $table->string('Jenis_Kelamin')->nullable();
            $table->string('Alamat')->nullable();
            $table->string('No_Telepon')->nullable();
            $table->string('Pemeriksaan');
            $table->string('Diagnosa');
            $table->string('Terapi');
            $table->date('Tanggal_Berobat');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_medis');
    }
}
