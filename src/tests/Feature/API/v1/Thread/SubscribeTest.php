<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplySubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    public function test_user_can_subscribe_to_a_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        $this->json('POST', route('subscribe', [$thread]), ['Accept' => 'application/json'])
            ->assertSuccessful()
            ->assertJson(['message'=> 'user subscribed successfully']);
        $this->assertTrue(Subscribe::where([
            ['user_id',$user->id],
            ['thread_id',$thread->id]
        ])->exists());
    }
    public function test_user_can_unsubscribe_to_a_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        $subscribe = Subscribe::factory()->create([
            'user_id'=>$user->id,
            'thread_id'=>$thread->id
        ]);
        $this->json('POST', route('unSubscribe', [$thread]), ['Accept' => 'application/json'])
            ->assertSuccessful()
            ->assertJson(['message'=> 'user unsubscribed successfully']);
        $this->assertFalse(Subscribe::whereId($subscribe->id)->exists());
    }


    public function test_notification_will_send_to_subscribers_of_a_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Notification::fake();

        $thread = Thread::factory()->create();

        $subscribe_response = $this->post(route('subscribe', [$thread]));
        $subscribe_response->assertSuccessful();
        $subscribe_response->assertJson([
            'message' => 'user subscribed successfully'
        ]);

        $answer_response = $this->postJson(route('answers.store'), [
            'content' => 'Foo',
            'thread_id' => $thread->id
        ]);
        $answer_response->assertSuccessful();
        $answer_response->assertJson([
            'message' => 'answer submitted successfully'
        ]);

        Notification::assertSentTo($user, NewReplySubmitted::class);
    }
}
