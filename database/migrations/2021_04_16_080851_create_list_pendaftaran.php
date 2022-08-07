<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListPendaftaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('Status_Antrian')->nullable();
            $table->string('No_Antrian');
            $table->date('Tanggal');
            $table->string('Jenis_Layanan');
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
        Schema::dropIfExists('list_pendaftaran');
    }
}
