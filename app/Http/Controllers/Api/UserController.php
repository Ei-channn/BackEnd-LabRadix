<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser(Request $request) {
        $user = $request->user();

        return response()->json($user);
    }

    public function index() {
        $users = User::whereIn('role', ['dokter', 'petugas_lab'])->get();

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }
}
