<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jenis_pemeriksaan extends Model
{
    protected $fillable = [
        'nama_jenis',
        'kategori',
    ];

    public function parameterPemeriksaan() {
        return $this->hasMany(parameter_pemeriksaan::class, 'id_jenis');
    }

    public function permintaanPemeriksaan() {
        return $this->hasMany(permintaan_pemeriksaan::class);
    }
}
