<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function statistikPermintaan()
    {
        $total = DB::table('permintaan_pemeriksaans')->count();

        $kategori = DB::table('permintaan_pemeriksaans')
            ->join('jenis_pemeriksaans', 'permintaan_pemeriksaans.id_jenis', '=', 'jenis_pemeriksaans.id')
            ->select('jenis_pemeriksaans.kategori', DB::raw('count(*) as total'))
            ->groupBy('jenis_pemeriksaans.kategori')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [ 
                'total_permintaan' => $total,
                'per_kategori' => $kategori
            ]
        ]);
    }
}
