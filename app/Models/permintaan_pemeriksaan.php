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

    public function dokter() {
        return $this->belongsTo(dokter::class);
    }

    public function pasien() {
        return $this->belongsTo(pasien::class);
    }

    public function jenisPemeriksaan() {
        return $this->belongsTo(jenis_pemeriksaan::class);
    }

    public function hasilPemeriksaan() {
        return $this->hasMany(hasil_pemeriksaan::class);
    }
}
