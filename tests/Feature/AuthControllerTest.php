<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * Registration test
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $data = [
            "email" => "foulen@yama.com",
            "name" => "foulen ben foulen",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $response = $this->postJson(route("register"), $data);

        $response->assertOk();

        $this->assertModelExists(User::where("email", $data["email"])->first());
        $this->assertDatabaseHas("users", [
            "email" => "foulen@yama.com",
            "name" => "foulen ben foulen"
        ]);
    }


    /**
     * Registration validation test
     *
     * @return void
     */
    public function test_user_cannot_register_when_input_isnt_valid()
    {
        User::factory()->create(["email" => "foulen@yama.com"]);
        $data = [
            "email" => "foulen@yama.com",
            "name" => "foulen ben foulen",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $response = $this->postJson(route("register"), $data);

        $response->assertJsonValidationErrorFor("email");


        $data = [
            "email" => "foulenx@yama.com",
            "name" => "foulen ben foulen",
            "password" => "password",
            "password_confirmation" => "xpassword"
        ];

        $response = $this->postJson(route("register"), $data);

        $response->assertJsonValidationErrorFor("password");
    }

    /**
     * Login test
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $creadentials = [
            "email" =>  "foulen@yama.com",
            "password" =>  "password",
        ];
        User::factory()->create(["email" => $creadentials["email"]]);

        Artisan::call('passport:install');

        $response = $this->postJson(route("login"), $creadentials);

        $response->assertOk();

        $response->assertJsonPath("message" , "User logged in successfully");

    }
}
