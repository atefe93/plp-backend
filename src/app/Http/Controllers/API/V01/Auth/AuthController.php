<?php

namespace App\Http\Controllers\API\V01\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register New User
     * @method POST
     * @param Request $request
     */
    public function register(Request $request)
    {

        $request->validate([
            'name'=>['required'],
            'email'=>['required','email','unique:users'],
            'password'=>['required'],
        ]);

        resolve(UserRepository::class)->create($request);

        return response()->json([
            'message'=>'user created successfully'
        ],201);
    }

    /**
     * login user
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        //Validate Form Inputs

        $request->validate([
            'email'=>['required','email'],
            'password'=>['required'],
        ]);

        //Check User Credentials For Login
        if (Auth::attempt($request->only(['email','password']))){

            return response()->json(Auth::user(),200);

        }
        throw ValidationException::withMessages([
            'email'=>'incorrect credentials'
        ]);
    }

    public function user()
    {
        return response()->json(Auth::user(),200);

    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message'=>'logged out successfully'
        ],200);

    }


}
