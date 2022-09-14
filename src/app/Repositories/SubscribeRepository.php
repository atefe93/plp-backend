<?php


namespace App\Repositories;




use App\Models\Subscribe;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SubscribeRepository
{
    public function subscribe(Thread $thread)
    {
        auth()->user()->subscribes()->create([
            'thread_id' => $thread->id
        ]);
    }
    public function unSubscribe(Thread $thread)
    {
        Subscribe::query()->where([
            ['thread_id', $thread->id],
            ['user_id', auth()->id()]
        ])->delete();
    }
}
