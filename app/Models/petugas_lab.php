<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class petugas_lab extends Model
{
    protected $fillable = [
        'user_id',
        'nama_petugas',
        'no_telp',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function hasilPemeriksaan() {
        return $this->hasMany(hasil_pemeriksaan::class);
    }

    public function distribusiHasil() {
        return $this->hasMany(distribusi_hasil::class);
    }
}
