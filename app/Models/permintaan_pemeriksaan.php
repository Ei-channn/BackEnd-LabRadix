<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permintaan_pemeriksaan extends Model
{
    protected $fillable = [
        'no_permintaan',
        'id_pasien',
        'id_dokter',
        'id_jenis',
        'tanggal_permintaan',
        'status_pemeriksaan',
    ];

    public function dokter() {
        return $this->belongsTo(dokter::class, 'id_dokter');
    }

    public function pasien() {
        return $this->belongsTo(pasien::class, 'id_pasien');
    }

    public function jenisPemeriksaan() {
        return $this->belongsTo(jenis_pemeriksaan::class, 'id_jenis');
    }

    public function hasilPemeriksaan() {
        return $this->hasMany(hasil_pemeriksaan::class);
    }

    public function distribusiHasil() {
        return $this->hasMany(distribusi_hasil::class);
    }

}
