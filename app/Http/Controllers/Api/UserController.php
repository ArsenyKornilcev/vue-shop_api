<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = auth('api')->attempt($credentials)) {
            return response()->json(['token' => $token], 200);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
