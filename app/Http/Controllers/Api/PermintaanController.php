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
        $permintaan = permintaan_pemeriksaan::with('dokter.user', 'pasien', 'jenisPemeriksaan.parameterPemeriksaan')->paginate(10);

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

    public function show($id) {
        $permintaan = permintaan_pemeriksaan::with('dokter', 'pasien', 'jenisPemeriksaan.parameterPemeriksaan')->find($id);

        if(!$permintaan) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan');
        }

        return new ApiResource($permintaan, true, 'Data Berhasil Ditampilkan');
    }

    public function update(Request $request, $id) {
        $permintaan = permintaan_pemeriksaan::find($id);

        if(!$permintaan) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'id_pasien' => 'nullable|exists:pasiens,id',
            'id_jenis' => 'nullable|exists:jenis_pemeriksaans,id',
            'tanggal_permintaan' => 'nullable|date',
            'status_pemeriksaan' => 'nullable|string',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $permintaan->update([
            'id_pasien' => $request->id_pasien ?? $permintaan->id_pasien,
            'id_dokter' => auth()->id(),
            'id_jenis' => $request->id_jenis ?? $permintaan->id_jenis,
            'tanggal_permintaan' => $request->tanggal_permintaan ?? $permintaan->tanggal_permintaan,
            'status_pemeriksaan' => $request->status_pemeriksaan ?? $permintaan->status_pemeriksaan,
        ]);

        return new ApiResource($permintaan, true, 'Data Berhasil Diupdate');
    }

    public function destroy($id) {
        $permintaan = permintaan_pemeriksaan::find($id);

        if(!$permintaan) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan');
        }

        return new ApiResource(null, true, 'Data Berhasil Dihapus');
    }
}
