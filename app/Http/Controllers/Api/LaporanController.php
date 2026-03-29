<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pasien;
use App\Models\permintaan_pemeriksaan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index() {
        $today = now();

        return response()->json([
            'pasien_harian' => pasien::whereDate('created_at' , $today)->count(),
            'data_pasien_harian' => pasien::whereDate('created_at' , $today)->get(),
            
            'permintaan_harian' => permintaan_pemeriksaan::whereDate('created_at' , $today)->count(),

            'total_pasien' => DB::table('pasiens')->count(),
            'total_dokter' => DB::table('users')->where('role','dokter')->count(),
            'total_petugas_lab' => DB::table('users')->where('role','petugas_lab')->count(),
        ]);
    }
}
