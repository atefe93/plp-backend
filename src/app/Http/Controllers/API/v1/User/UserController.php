<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userNotifications()
    {

      return  response()->json(auth()->user()->unreadNotifications(), Response::HTTP_OK);

    }

    public function leaderboards()
    {
        return resolve(UserRepository::class)->leaderboards();
    }



}
