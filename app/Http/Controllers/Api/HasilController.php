<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hasil_pemeriksaan;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HasilController extends Controller
{
    public function index() {

        $dataHasil = [];

        $hasil = hasil_pemeriksaan::with('permintaanPemeriksaan.dokter',
                                         'permintaanPemeriksaan.pasien',
                                         'parameterPemeriksaan')
                                    ->paginate(10);

        if($hasil->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan');
        }

        $dataHasil[] = $hasil;

        return new ApiResource($dataHasil, true, 'Data Berhasil Ditampilkan');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_permintaan' => 'required|exists:permintaan_pemeriksaans,id',
            'hasil' => 'required|array',
            'hasil.*.id_parameter' => 'required|exists:parameter_pemeriksaans,id',
            'hasil.*.nilai_hasil' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $dataHasil = [];

        $permintaan = DB::table('permintaan_pemeriksaans')
            ->where('id', $request->id_permintaan)
            ->first();

        $totalParameter = DB::table('parameter_pemeriksaans')
            ->where('id_jenis', $permintaan->id_jenis)
            ->count();

        if(count($request->hasil) != $totalParameter){
            return new ApiResource(null, false, 'Jumlah parameter tidak lengkap', 422);
        }

        DB::transaction(function() use ($request, &$dataHasil){

            foreach($request->hasil as $data){

                $parameter = DB::table('parameter_pemeriksaans')
                    ->where('id',$data['id_parameter'])
                    ->first();

                $status = 'normal';

                if($data['nilai_hasil'] < $parameter->nilai_normal_min){
                    $status = 'rendah';
                }elseif($data['nilai_hasil'] > $parameter->nilai_normal_max){
                    $status = 'tinggi';
                }

                DB::table('permintaan_pemeriksaans')
                    ->where('id', $request->id_permintaan)
                    ->update([
                        'status_pemeriksaan' => 'selesai'
                    ]);

                $hasil = hasil_pemeriksaan::create([
                    'id_permintaan' => $request->id_permintaan,
                    'id_parameter' => $data['id_parameter'],
                    'nilai_hasil' => $data['nilai_hasil'],
                    'status' => $status
                ]);

                $dataHasil[] = $hasil;
            }
        });
        return new ApiResource($dataHasil, true, 'Data Berhasil Ditambahkan', 201);
    }

    public function show($id) {
        $dataHasil = [];

        $hasil = hasil_pemeriksaan::with('permintaanPemeriksaan.dokter',
                                         'permintaanPemeriksaan.pasien',
                                         'parameterPemeriksaan')
                                    ->find($id);

        if(!$hasil) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        $dataHasil[] = $hasil;

        return new ApiResource($dataHasil, true, 'Data Berhasil Ditampilkan', 200);
    }

    
 
}
