<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permintaan_pemeriksaan extends Model
{
    protected $fillable = [
        'id_pasien',
        'id_dokter',
        'id_jenis',
        'tangaal_permintaan',
        'status_pemeriksaan',
    ];
}
