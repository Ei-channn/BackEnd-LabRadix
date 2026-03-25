<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hasil_pemeriksaan extends Model
{
    protected $fillable = [
        'id_permintaan',
        'id_parameter',
        'id_petugas',
        'nilai_hasil',
        'status',
    ];

    public function distribusiHasil() {
        return $this->hasMany(distribusi_hasil::class);
    }

    public function permintaanPemeriksaan() {
        return $this->belongsTo(permintaan_pemeriksaan::class, 'id_permintaan');
    }

    public function parameterPemeriksaan() {
        return $this->belongsTo(parameter_pemeriksaan::class, 'id_parameter');
    }

    public function petugasLab() {
        return $this->belongsTo(petugas_lab::class, "id_petugas");
    }
}
