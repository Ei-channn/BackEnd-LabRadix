<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class distribusi_hasil extends Model
{
    protected $fillable = [
        'id_permintaan',
        'id_user',
        'tanggal_kirim',
        'dikirim_ke_dokter',
        'dikirim_ke_pasien',
        'metode_pengiriman',
    ];

    public function permintaanPemeriksaan() {
        return $this->belongsTo(permintaan_pemeriksaan::class, 'id_permintaan');
    }

    public function user() {
        return $this->belongsTo(User::class, "id_user");
    }
} 
