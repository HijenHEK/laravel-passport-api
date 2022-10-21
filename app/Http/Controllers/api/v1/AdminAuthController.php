<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\ApiBaseResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;

class AdminAuthController extends Controller
{

    use ApiBaseResponse;

    /**
     * login url
     * @var $login_url
     */
    protected $login_url ;

    public function __construct()
    {
        $this->login_url =  config('app.login_url');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);


        $passport_client = Passport::client()->where('name', "admins")->first();

        $response = Http::asForm()->post( $this->login_url . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $passport_client->id,
            'client_secret' => $passport_client->secret,
            'username' => $data['email'],
            'password' => $data['password'],
            'scope' => '*',
        ]);

        return $response->json();


   
    }

    public function Register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed'
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = Admin::create($data);

        return $this->success([
            'message' => 'Admin registered successfully !'
        ]);
    }

    public function Logout(Request $request)
    {
        auth()->user()->tokens->each(function($token, $key) {
            $token->delete();
        });

        return $this->success([
            'message' => 'Admin Logged out successfully !'
        ]);
    }

    public function refresh(Request $request){


        $data = $request->validate([
            'refresh_token' => 'string'
        ]);

        $passport_client = Passport::client()->where('password_client',1 )->first();

        $response = Http::asForm()->post( $this->login_url . '/oauth/token/refresh', [
            'grant_type' => 'refresh_token',
            'client_id' => $passport_client->id,
            'client_secret' => $passport_client->secret,
            'refresh_token' => $data['refresh_token'],

            'scope' => '*',
        ]);

        return $response->json();

    }
}
