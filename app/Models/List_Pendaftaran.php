<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class List_Pendaftaran extends Model
{
    protected $table = 'list_pendaftaran';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function dtpasien()
    {
        return $this->belongsTo(Data_Pasien::class, 'No_Rekam_Medis');
    }

}


