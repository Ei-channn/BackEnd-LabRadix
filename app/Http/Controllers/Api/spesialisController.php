<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\spesialis;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class spesialisController extends Controller
{
    public function index() {
        $spesialis = spesialis::paginate(10);

        if($spesialis->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($spesialis, true, 'Data Berhasil Ditampilkan', 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_spesialis' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagagl', 422);
        }

        $spesialis = spesialis::create($request->all());

        return new ApiResource($spesialis, true, 'Data Berhasil Ditambah', 201);
    }

    public function show($id) {
        $spesialis = spesialis::find($id);

        if(!$spesialis) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($spesialis, true, 'Data Berhasil Ditampilkan', 200);
    }

    public function update(Request $request, $id) {
        $spesialis = spesialis::find($id);

        $validator = Validator::make($request->all(), [
            'nama_spesialis' => 'required',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $spesialis->update([
            'nama_spesialis' => $request->nama_spesialis ?? $spesialis->nama_spesialis,
        ]);

        return new ApiResource($spesialis, true, 'Data Berhasil Diupdate', 200);
    }

    public function destroy($id){
        $spesialis = spesialis::find($id);

        if(!$spesialis) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource(null, true, 'Data Berhasil Dihapus', 200);
    }

}
