<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateDataPasien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pasien', function (Blueprint $table) {
            $table->bigIncrements('No_Medis')->unsigned();
            $table->string('No_BPJS')->nullable();
            $table->string('Nama');
            $table->string('Umur');
            $table->string('Jenis_Kelamin');
            $table->string('Alamat');
            $table->string('No_Telepon');
            $table->string('Jenis_Pasien');
            $table->string('Status_BPJS');
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
        Schema::dropIfExists('data_pasien');
    }
}
