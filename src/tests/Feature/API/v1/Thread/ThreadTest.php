<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
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
    public function test_create_thread_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->json('POST', route('threads.store'),[], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }
    public function test_create_new_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $Data = [
            "title" => "foo",
            "content" => "bar",
            "channel_id" => Channel::factory()->create()->id,
        ];
        $this->json('POST', route('threads.store'), $Data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function test_update_thread_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();

        $this->json('Put', route('threads.update',[$thread]),[], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_thread_update()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create([
            'title' => 'foo',
            "content" => "bar",
            "channel_id" => Channel::factory()->create()->id,
            "user_id"=>$user->id
        ]);


        $Data = [
            "title" => "bar",
            "content" => "bar",
            "channel_id" => Channel::factory()->create()->id,
        ];

        $this->json('Put', route('threads.update',[$thread]), $Data, ['Accept' => 'application/json'])
            ->assertSuccessful();
        $thread->refresh();
        $this->assertSame('bar', $thread->title);

    }
    public function test_add_best_answer_id_for_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create([
            "user_id"=>$user->id
        ]);


        $Data = [
            "best_answer_id" =>1,

        ];

        $this->json('Put', route('threads.update',[$thread]), $Data, ['Accept' => 'application/json'])
            ->assertSuccessful();
        $thread->refresh();
        $this->assertSame(1, $thread->best_answer_id);

    }
    public function test_thread_delete()
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create([
            "user_id"=>$user->id
        ]);

        $this->json('DELETE', route('threads.destroy',[$thread->id]) , ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
    }
}
