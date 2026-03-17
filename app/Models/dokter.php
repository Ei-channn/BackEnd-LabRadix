<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokter extends Model
{
    protected $fillable = [
        'nama_dokter',
        'spesialis',
        'no_telp',
    ];

    public function permintaanPemeriksaan() {
        return $this->hasMany(permintaan_pemeriksaan::class);
    }
}
