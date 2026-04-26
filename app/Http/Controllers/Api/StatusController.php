<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
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

    public function statusPemeriksaan()
    {
        return response()->json([
            'kritis' => DB::table('hasil_pemeriksaans')->where('status','kritis')->count(),
            'normal' => DB::table('hasil_pemeriksaans')->where('status','normal')->count(),
            'tinggi' => DB::table('hasil_pemeriksaans')->where('status','tinggi')->count(),
            'rendah' => DB::table('hasil_pemeriksaans')->where('status','rendah')->count(),
        ]);
    }

    public function statusMingguan()
    {
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        $data = DB::table('hasil_pemeriksaans')
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw("SUM(status = 'normal') as normal"),
                DB::raw("SUM(status = 'tinggi') as tinggi"),
                DB::raw("SUM(status = 'rendah') as rendah"),
                DB::raw("SUM(status = 'kritis') as kritis")
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return response()->json($data);
    }
}
