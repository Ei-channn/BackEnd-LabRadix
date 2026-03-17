<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class distribusi_hasil extends Model
{
    protected $fillable = [
        'id_hasil',
        'tanggal_kirim',
        'dikirim_ke_dokter',
        'dikirim_ke_pasien',
        'metode_pengiriman',
    ];

    public function hasilPemeriksaan() {
        return $this->belongsTo(hasil_pemeriksaan::class);
    }
} 
