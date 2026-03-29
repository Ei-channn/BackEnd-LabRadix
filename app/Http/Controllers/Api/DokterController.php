<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\dokter;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    public function index() {
        $dokter = dokter::with('user')->paginate(10);

        if ($dokter->isEmpty()){
            return new ApiResource(null, false, 'Tidak ada Data', 404);
        }

        return new ApiResource($dokter, true, 'Data Berhasil Diambil', 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'id_spesialis' => 'required|exists:spesialis,id',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $dokter = dokter::create([
            'user_id' => $request->user_id,
            'id_spesialis' => $request->id_spesialis,
        ]);

        return new ApiResource($dokter, true, 'Data Berhasil Ditambahkan', 201);
    }

    public function show($id) {
        $dokter = dokter::find($id);

        if (!$dokter){
            return new ApiResource(null, false, 'Tidak ada Data', 404);
        }

        return new ApiResource($dokter, true, 'Data Berhasil Diambil', 200);
    }

    public function update(Request $request, $id) {

        $dokter = dokter::find($id);

        $validator = Validator::make($request->all(), [
            'id_spesialis' => 'nullable||exists:spesialis,id',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $dokter->update([
            'id_spesialis' => $request->id_spesialis ?? $dokter->id_spesialis,
        ]);

        return new ApiResource($user->dokter, true, 'Data Berhasil Diupdate', 200);
    }

    public function destroy($id) {
        $dokter = dokter::find($id);

        if(!$dokter) {
            return new ApiResource(null, false, 'Tidak ada Data', 404);
        }

        $dokter->delete();

        return new ApiResource(null, true, 'Data Berhasil Dihapus', 200);
    }

}
