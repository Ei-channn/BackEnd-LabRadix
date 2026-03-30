<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class spesialis extends Model
{
    protected $fillable = [
        'nama_spesialis',
    ];

    public function dokter() {
        return $this->hasMany(dokter::class, 'id_spesialis');
    }
}
