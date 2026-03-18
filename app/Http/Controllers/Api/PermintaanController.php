<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\permintaan_pemeriksaan;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class PermintaanController extends Controller
{
    public function index() {
        $permintaan = permintaan_pemeriksaan::with('dokter', 'pasien', 'jenisPemeriksaan.parameterPemeriksaan')->paginate(10);

        if($permintaan->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($permintaan, true, 'Data Berhasil Diambil', 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_pasien' => 'required|exists:pasiens,id',
            'id_jenis' => 'required|exists:jenis_pemeriksaans,id',
            'tanggal_permintaan' => 'required|date',
            'status_pemeriksaan' => 'required|string',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $permintaan = permintaan_pemeriksaan::create([
            'id_pasien' => $request->id_pasien,
            'id_dokter' => auth()->id(),
            'id_jenis' => $request->id_jenis,
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'status_pemeriksaan' => $request->status_pemeriksaan,
        ]);

        return new ApiResource($permintaan, true, 'Data Berhasil Ditambahkan');
    }
}
