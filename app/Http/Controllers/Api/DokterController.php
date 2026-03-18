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
        $dokter = dokter::paginate(10);

        if ($dokter->isEmpty()){
            return new ApiResource(null, false, 'Tidak ada Data', 404);
        }

        return new ApiResource($dokter, true, 'Data Berhasil Diambil', 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'spesialis' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $dokter = dokter::create([
            'user_id' => auth()->id(),
            'nama_dokter' => auth()->user()->name,
            'spesialis' => $request->spesialis,
            'no_telp' => $request->no_telp,
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
        $user = auth()->user();

        $dokter = $user->dokter;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $user->update([
            'name' => $request->name ?? $user->name,
        ]);

        $dokter->update([
            'nama_dokter' => $request->name,
            'spesialis' => $request->spesialis ?? $dokter->spesialis,
            'no_telp' => $request->no_telp ?? $dokter->no_telp,
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
