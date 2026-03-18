<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokter extends Model
{
    protected $fillable = [
        'user_id',
        'nama_dokter',
        'spesialis',
        'no_telp',
    ];

    public function permintaanPemeriksaan() {
        return $this->hasMany(permintaan_pemeriksaan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
