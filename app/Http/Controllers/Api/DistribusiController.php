<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\distribusi_hasil;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class DistribusiController extends Controller
{
    public function index() {
        $distribusi = distribusi_hasil::with('user')->paginate(10);

        if($distribusi->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($distribusi, true, 'Data Berhasil Diambil', 200);
    }

    public function store(Request $request) {
       $validator = Validator::make($request->all(), [
            'id_permintaan' => 'required|exists:permintaan_pemeriksaans,id',
            'tanggal_kirim' => 'required|date',
            'dikirim_ke_dokter' => 'required|boolean',
            'dikirim_ke_pasien' => 'required|boolean',
            'metode_pengiriman' => 'required|string'
       ]);

       if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
       }

       $UserId = auth()->user()->id;

       $distribusi = distribusi_hasil::create([
            'id_permintaan' => $request->id_permintaan,
            'id_user' => $UserId,
            'tanggal_kirim' => $request->tanggal_kirim,
            'dikirim_ke_dokter' => $request->dikirim_ke_dokter,
            'dikirim_ke_pasien' => $request->dikirim_ke_pasien,
            'metode_pengiriman' => $request->metode_pengiriman,
       ]);

       return new ApiResource($distribusi, true, 'Data Berhasil Ditambahkan', 201);
    }

    public function show($id) {
        $distribusi = distribusi_hasil::with('hasilPemeriksaan')->find($id);

        if(!$distribusi) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($distribusi, true, 'Data Berhasil Ditampilkan', 200);
    }

    public function update(Request $request, $id) {
        $distribusi = distribusi_hasil::find($id);

        $validator = Validator::make($request->all(), [
            'id_permintaan' => 'nullable|exists:permintaan_pemeriksaans,id',
            'tanggal_kirim' => 'nullable|date',
            'dikirim_ke_dokter' => 'nullable|boolean',
            'dikirim_ke_pasien' => 'nullable|boolean',
            'metode_pengiriman' => 'nullable|string'
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $UserId = auth()->user()->id;

        $distribusi->update([
            'id_permintaan' => $request->id_permintaan ?? $distribusi->id_permintaan,
            'id_user' => $UserId,
            'tanggal_kirim' => $request->tanggal_kirim ?? $distribusi->tanggal_kirim,
            'dikirim_ke_dokter' => $request->dikirim_ke_dokter ?? $distribusi->dikirim_ke_dokter,
            'dikirim_ke_pasien' => $request->dikirim_ke_pasien ?? $distribusi->dikirim_ke_pasien,
            'metode_pengiriman' => $request->metode_pengiriman ?? $distribusi->metode_pengiriman,
        ]);

        return new ApiResource($distribusi, true, 'Data Berhasil Diupdate', 200);
    }

    public function destroy($id) {
        $distribusi = distribusi_hasil::find($id);

        if(!$distribusi) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        $distribusi->delete();

        return new ApiResource(null, true, 'Data Berhasil Dihapus', 200);
    }
 }
