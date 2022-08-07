<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_Pasien extends Model
{
    protected $table = 'data_pasien';
    protected $primaryKey = 'No_Medis';
    protected $guarded = [];

    public function list()
    {
        return $this->hasMany(List_Pendaftaran::class, 'No_Medis');
    }

    public function umum()
    {
        return $this->hasMany(Laporan_Medis::class, 'No_Medis');
    }
}
