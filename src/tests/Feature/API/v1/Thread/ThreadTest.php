<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    public function test_all_threads_list_should_be_accessible()
    {
        $this->json('GET', route('threads.index'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_thread_should_be_accessible_by_slug()
    {
        $thread=Thread::factory()->create();

        $this->json('GET', route('threads.show',[$thread->slug]), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);

    }
}
