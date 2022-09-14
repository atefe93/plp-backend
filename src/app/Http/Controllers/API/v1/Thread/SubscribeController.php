<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Repositories\SubscribeRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscribeController extends Controller
{
    public function subscribe(Thread $thread)
    {
        resolve(SubscribeRepository::class)->subscribe($thread);
        return response()->json([
            'message'=> 'user subscribed successfully'
        ],Response::HTTP_OK);
    }
    public function unSubscribe(Thread $thread)
    {
        resolve(SubscribeRepository::class)->unSubscribe($thread);

        return response()->json([
            'message'=> 'user unsubscribed successfully'
        ],Response::HTTP_OK);
    }





}
