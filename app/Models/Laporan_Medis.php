<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan_Medis extends Model
{
    protected $table = 'laporan_medis';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function dtpasien()
    {
        return $this->belongsTo(Data_Pasien::class, 'No_Rekam_Medis');
    }
}
