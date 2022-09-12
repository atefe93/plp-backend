<?php


namespace App\Repositories;



use App\Models\Thread;
use Illuminate\Http\Request;


class ThreadRepository
{
    public function getAllAvailableThreads()
    {
        $threads = Thread::whereFlag(1)->latest()->get();
        return $threads;
    }
    public function getThreadBySlug($slug)
    {
        $thread = Thread::whereSlug($slug)->whereFlag(1)->first();
        return $thread;
    }
}
