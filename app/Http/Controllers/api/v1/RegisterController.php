<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiBaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    use ApiBaseResponse;

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
}
