<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jenis_pemeriksaan extends Model
{
    protected $fillable = [
        'nama_jenis',
        'kategori',
    ];
}
