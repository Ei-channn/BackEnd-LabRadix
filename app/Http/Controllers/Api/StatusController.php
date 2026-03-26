<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function statusPermintaan()
    {
        return response()->json([
            'antri' => DB::table('permintaan_pemeriksaans')->where('status_pemeriksaan','antri')->count(),
            'proses' => DB::table('permintaan_pemeriksaans')->where('status_pemeriksaan','proses')->count(),
            'selesai' => DB::table('permintaan_pemeriksaans')->where('status_pemeriksaan','selesai')->count(),
        ]);
    }

    public function statusKritis()
    {
        $kritis = DB::table('hasil_pemeriksaans')
            ->where('status', 'kritis')
            ->count();

        return response()->json([
            'success' => true,
            'data' => $kritis
        ]);
    }
}
