<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\petugas_lab;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class labController extends Controller
{
    public function index() {
        $petugas = petugas_lab::with('user')->paginate(10);

        if($petugas->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($petugas, true, 'Data Berhasil Ditampilkan', 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'no_telp' => 'required|string|max:20'
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $petugas = petugas_lab::create([
            'user_id' => auth()->id(),
            'nama_petugas' => auth()->user()->name,
            'no_telp' => $request->no_telp,
        ]);

        return new ApiResource($petugas, true, 'Data Berhasil Ditambahkan', 201);
    } 

    public function show($id) {
        $petugas = petugas_lab::find($id);

        if(!$petugas) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($petugas, true, 'Data Berhasil Diambil', 200);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $petugas = petugas_lab::find($id);

        $user = auth()->user();

        $user->update([
            'name' => $request->name ?? $user->name,
        ]);

        $petugas->update([
            'nama_petugas' => $request->name ?? $petugas->nama_petugas,
            'no_telp' => $request->no_telp ?? $petugas->no_telp,
        ]);

        return new ApiResource($petugas, true, 'Data Berhasil Diupdate', 200);
    }

    public function destroy($id) {
        $petugas = petugas_lab::find($id);

        if(!$petugas) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource(null, true, 'Data Berhasil Dihapus', 200);
    } 
}
