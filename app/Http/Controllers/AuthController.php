<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'status'  => 'FAIL',
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'status'=> 'OK',
            'token' => $token,
            'data'  => auth()->user()
        ]);
    }

    public function logout(){
        auth()->logout();

        return response()->noContent();
    }
}
