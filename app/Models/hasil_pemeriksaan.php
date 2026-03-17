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

    public function distribusiHasil() {
        return $this->hasMany(distribusi_hasil::class);
    }

    public function permintaanPemeriksaan() {
        return $this->belongsTo(permintaan_pemeriksaan::class);
    }
}
