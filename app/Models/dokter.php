<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokter extends Model
{
    protected $fillable = [
        'user_id',
        'id_spesialis',
    ];

    public function permintaanPemeriksaan() {
        return $this->hasMany(permintaan_pemeriksaan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function spesialis() {
        return $this->belongsTo(spesialis::class, 'id_spesialis');
    }
}
