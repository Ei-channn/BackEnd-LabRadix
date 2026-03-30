<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\dokter;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        $user = User::with('dokter.spesialis')->paginate(10);

        if($user->isEmpty()) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($user, true, 'Data Berhasil Diambil', 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|max:20',
            'role' => 'required|string',
            'no_telp' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return new ApiResource($validator->errors(), false, 'Validasi gagal', 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'no_telp' => $request->no_telp,
        ]);

        return new ApiResource($user, true, 'Data Berhasil Ditambah', 201);
    }

    public function show($id) {
        $user = User::find($id);

        if(!$user) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        return new ApiResource($user, true, 'Data Berhasil Ditampilkan', 200);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        if(!$user) {
            return new ApiResource(null, false, 'Data Tidak Ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:20',
            'no_telp' => 'nullable|numeric',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ?? $user->password,
            'role' => $request->role ?? $user->role,
            'no_telp' => $request->no_telp ?? $user->no_telp,
        ]); 

        return new ApiResource($user, true, 'Data Berhasil Diupdate', 200);
    }

    public function destroy($id) {
        $dokter = Dokter::where('user_id', $id)->first();

        if($dokter){
            $dokter->delete();
        }

        User::destroy($id);

        return response()->json([
            "message" => "deleted"
        ]);
    }

    public function getUser(Request $request) {
        $user = $request->user();

        return response()->json($user);
    }

    public function getRole() {
        $users = User::whereIn('role', ['dokter', 'petugas_lab'])->get();

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }
}
