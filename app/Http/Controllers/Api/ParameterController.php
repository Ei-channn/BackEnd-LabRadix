<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\parameter_pemeriksaan;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class ParameterController extends Controller
{
    public function index() {
        $parameter = parameter_pemeriksaan::with('jenisPemeriksaan')->paginate(10);

        if($parameter->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan'. 404);
        }

        return new ApiResource($parameter, true, 'Data Berhasil Ditampilkan'. 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_parameter' => 'required|string|max:255',
            'id_jenis' => 'required|numeric|exists:jenis_pemeriksaans,id',
            'nilai_normal_min' => 'required|numeric|max:255',
            'nilai_normal_max' => 'required|numeric|max:255',
            'satuan' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $parameter = parameter_pemeriksaan::create($request->all());

        return new ApiResource($parameter, true, 'Data Berhasil Ditambahkan', 201);
    }

    public function show($id) {
        $parameter = parameter_pemeriksaan::with('jenisPemeriksaan')->find($id);

        if(!$parameter) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($parameter, true, 'Data Berhasil Diambil', 200);
    }

    public function update(Request $request, $id) {
        $parameter = parameter_pemeriksaan::find($id);

        if(!$parameter) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_parameter' => 'nullable|string|max:255',
            'id_jenis' => 'nullable|numeric|exists:jenis_pemeriksaans,id',
            'nilai_normal_min' => 'nullable|numeric|max:255',
            'nilai_normal_max' => 'nullable|numeric|max:255',
            'satuan' => 'nullable|string|max:255',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $parameter->update([
            'nama_parameter' => $request->nama_parameter ?? $parameter->nama_parameter,
            'id_jenis' => $request->id_jenis ?? $parameter->id_jenis,
            'nilai_satuan_min' => $request->nilai_satuan_min ?? $parameter->nilai_satuan_min,
            'nilai_satuan_max' => $request->nilai_satuan_max ?? $parameter->nilai_satuan_max,
            'satuan' => $request->satuan ?? $parameter->satuan,
        ]);

        return new ApiResource($parameter, true, 'Data Berhasil Diupdate', 200);
    }

    public function destroy($id) {
        $parameter = parameter_pemeriksaan::find($id);

        if(!$parameter) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan');
        }

        $parameter->delete();

        return new ApiResource(null, true, 'Data Berhasil Dihapus');
    }

    public function getParameter($id) {
        $parameter = parameter_pemeriksaan::where('id_jenis', $id)->get();

        if(!$parameter) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }
 
        return response()->json([
            'massage' => true,
            'data' => $parameter,
        ]);
    }
}
