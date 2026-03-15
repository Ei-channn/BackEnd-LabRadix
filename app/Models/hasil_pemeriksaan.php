<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hasil_pemeriksaan extends Model
{
    protected $fillable = [
        'id_permintaan',
        'id_parameter',
        'nilai_hasil',
        'status',
    ];
}
