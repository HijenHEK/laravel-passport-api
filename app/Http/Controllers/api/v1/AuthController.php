<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiBaseResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    use ApiBaseResponse;

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!auth()->attempt($data)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return $this->success([
            'message' => 'User logged in successfully',
            'access_token' => $accessToken
        ]);
    }

    public function Register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return $this->success([
            'message' => 'User registered successfully !'
        ]);
    }

    public function Logout(Request $request)
    {
        auth()->user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return $this->success([
            'message' => 'User Logged out successfully !'
        ]);
    }
}
