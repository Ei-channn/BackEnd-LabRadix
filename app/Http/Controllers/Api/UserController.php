<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request) {
        $user = $request->user();

        return response()->json($user);
    }
}
