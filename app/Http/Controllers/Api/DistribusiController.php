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
        $distribusi = distribusi_hasil::paginate(10);

        if($distribusi->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan');
        }

        return new ApiResource($distribusi, true, 'Data Berhasil Diambil');
    }
}
