<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Models\pasien;
use Illuminate\Support\Facades\Validator;

class PasienController extends Controller
{
    public function index() {
        $pasien = pasien::paginate(10);

        if($pasien->isEmpty()) {
            return new ApiResource(null, false, "Data Tidak Ada", 404);
        }

        return new ApiResource($pasien, true, 'Data Berhasil Diambil', 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, "Validasi gagal", 422);
        }

        $pasien = pasien::create($request->all());

        return new ApiResource($pasien, true, 'Data Berhasil Ditambahkan', 201);
    }

    public function show($id) {
        $pasien = pasien::find($id);
        
        if(!$pasien) {
            return new ApiResource(null, false, 'Data Tidak Ada', 404);
        }

        return new ApiResource($pasien, true, 'Data Berhasil Diambil', 200);
    }

    public function update(Request $request, $id) {
        $pasien = pasien::find($id);

        if(!$pasien) {
            return new ApiResource(null, false, 'Data Tidak Ada', 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $pasien->update([
            'nama_pasien' => $request->nama_pasien ?? $pasien->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir ?? $pasien->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin ?? $pasien->jenis_kelamin,
            'alamat' => $request->alamat ?? $pasien->alamat,
            'no_telp' => $request->no_telp ?? $pasien->no_telp,
        ]);

        return new ApiResource($pasien, true, 'Data Berhasil Diupdate', 200);
    }

    public function destroy($id) {
        $pasien = pasien::find($id);

        if(!$pasien) {
            return new ApiResource(null, false, 'Data Tidak Ada', 404);
        }

        $pasien->delete();

        return new ApiResource(null, true, 'Data Berhasil Dihapus', 200);
    }

}
