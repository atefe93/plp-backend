<?php

namespace Tests\Unit\API\v1\Auth;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{


   /*
    * Test Register
   */


    public function test_register_should_be_validated()
    {
        $this->json('POST', route('auth.register'), ['Accept' => 'application/json'])

            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }
    public function test_new_user_can_register()
    {

        $userData = [
            "name" => "ohn Doe",
            "email" => "oeggllg@example.com",
            "password" => "demo12345",

        ];
        $this->json('POST', route('auth.register'), $userData, ['Accept' => 'application/json'])

            ->assertStatus(Response::HTTP_CREATED);

    }
    /*
    * Test Login
   */
    public function test_login_should_be_validated()
    {
        $this->json('POST', route('auth.login'), ['Accept' => 'application/json'])

            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_user_can_login_with_true_credentials()
    {
        $user = User::factory()->create();


        $loginData = ['email' => $user->email, 'password' => 'password'];

        $this->json('POST', route('auth.login'),$loginData, ['Accept' => 'application/json'])

            ->assertStatus(Response::HTTP_OK);

    }

    public function test_show_user_info_if_logged_in()
    {

        $user = User::factory()->create();

        $this->actingAs($user)->json('get', route('auth.user'), ['Accept' => 'application/json'])

            ->assertStatus(Response::HTTP_OK);
    }



    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->json('get', route('auth.logout'), ['Accept' => 'application/json'])

            ->assertStatus(Response::HTTP_OK);
    }
}


