<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function statusCount()
    {
        $status = DB::table('permintaan_pemeriksaans')
            ->select('status_pemeriksaan', DB::raw('count(*) as total'))
            ->groupBy('status_pemeriksaan')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $status
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
