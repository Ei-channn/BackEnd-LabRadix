<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    protected $fillable = [
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telp',
    ];

    public function permintaanPemeriksaan() {
        return $this->hasMany(permintaan_pemeriksaan::class);
    }
    
}
