<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\jenis_pemeriksaan;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class JenisController extends Controller
{
    public function index() {
        $jenis = jenis_pemeriksaan::withCount('parameterPemeriksaan')->paginate(10);

        if($jenis->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ada', 404);
        }

        return new ApiResource($jenis, true, 'Data Berhasil Ditampilkan', 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_jenis' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $jenis = jenis_pemeriksaan::create($request->all());

        return new ApiResource($jenis, true, 'Data Berhasil Ditambahkan', 201);
    }

    public function show($id){
        $jenis = jenis_pemeriksaan::find($id);

        if(!$jenis) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($jenis, true, 'Data Berhasil Diambil', 200);
    }

    public function update(Request $request, $id) {
        $jenis = jenis_pemeriksaan::find($id);

        if(!$jenis) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_jenis' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $jenis->update([
            'nama_jenis' => $request->nama_jenis ?? $jenis->nama_jenis,
            'kategori' => $request->kategori ?? $jenis->kategori,
        ]);

        return new ApiResource($jenis, true, 'Data Berhasil Diupdate');
    }

    public function destroy($id) {
        $jenis = jenis_pemeriksaan::find($id);

        if(!$jenis) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan');
        }

        $jenis->delete();

        return new ApiResource(null, true, 'Data Berhasil Dihapus');
    }
}
