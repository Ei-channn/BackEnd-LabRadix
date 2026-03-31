<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hasil_pemeriksaan extends Model
{
    protected $fillable = [
        'id_permintaan',
        'id_parameter',
        'id_user',
        'nilai_hasil',
        'status',
    ];

    public function permintaanPemeriksaan() {
        return $this->belongsTo(permintaan_pemeriksaan::class, 'id_permintaan');
    }

    public function parameterPemeriksaan() {
        return $this->belongsTo(parameter_pemeriksaan::class, 'id_parameter');
    }

    public function user() {
        return $this->belongsTo(User::class, "id_user");
    }
}
