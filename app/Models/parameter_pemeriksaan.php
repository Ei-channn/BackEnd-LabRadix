<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class parameter_pemeriksaan extends Model
{
    protected $fillable = [
        'nama_parameter',
        'id_jenis',
        'nilai_normal_min',
        'nilai_normal_max',
        'satuan',
    ];

    public function jenisPemeriksaan() {
        return $this->belongsTo(jenis_pemeriksaan::class);
    }

    public function hasilPemeriksaan() {
        return $this->hasMany(hasil_pemeriksaan::class);
    }
}
