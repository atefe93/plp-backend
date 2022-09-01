<?php

namespace Tests\Unit\Http\Controllers\API\V01\Auth;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
   use RefreshDatabase;

   /*
    * Test Register
   */

    public function test_register_should_be_validate()
    {
        $this->json('POST', route('auth.register'), ['Accept' => 'application/json'])

            ->assertStatus(422);

    }
    public function test_new_user_can_register()
    {
        $userData = [
            "name" => "ohn Doe",
            "email" => "oeggllg@example.com",
            "password" => "demo12345",

        ];
        $this->json('POST', route('auth.register'), $userData, ['Accept' => 'application/json'])

            ->assertStatus(201);

    }
    /*
    * Test Login
   */
    public function test_login_should_be_validate()
    {
        $this->json('POST', route('auth.login'), ['Accept' => 'application/json'])

            ->assertStatus(422);
    }
    public function test_user_can_login_with_true_credentials()
    {
        $user = User::factory()->create();


        $loginData = ['email' => $user->email, 'password' => 'password'];

        $this->json('POST', route('auth.login'),$loginData, ['Accept' => 'application/json'])

            ->assertStatus(200);

    }

    public function test_show_user_info_if_logged_in()
    {

        $user = User::factory()->create();

        $this->actingAs($user)->json('get', route('auth.user'), ['Accept' => 'application/json'])

            ->assertStatus(200);
    }



    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('get', route('auth.logout'), ['Accept' => 'application/json'])

            ->assertStatus(200);
    }
}


