<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_kerja', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->date('Tanggal');
            // $table->string('Jenis_Layanan');
            $table->string('Status');
            $table->time('Jam_Mulai');
            $table->time('Jam_Selesai');
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
        Schema::dropIfExists('jadwal_kerja');
    }
}
