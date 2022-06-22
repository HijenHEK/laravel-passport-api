<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(! auth()->attempt($data)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

         $accessToken = auth()->user()->createToken('authToken')->accessToken ;

         return response()->json([
             'user' => auth()->user(),
             'access_token' => $accessToken
         ]);
    }
}
