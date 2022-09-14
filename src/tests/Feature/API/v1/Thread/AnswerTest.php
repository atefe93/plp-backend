<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    public function test_all_answers_list_should_be_accessible()
    {
        $this->json('GET', route('answers.index'), ['Accept' => 'application/json'])
            ->assertSuccessful();
    }

    public function test_create_answer_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->json('POST', route('answers.store'), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['content', 'thread_id']);


    }

    public function test_create_new_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $threat = Thread::factory()->create();
        $this->json('POST', route('answers.store'),
            [
                "content" => "bar",
                "thread_id" => $threat->id,
            ]
            , ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'answer submitted successfully']);
        $this->assertTrue($threat->answers()->where('content', 'bar')->exists());

    }
    public function test_update_answer_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer=Answer::factory()->create();
        $this->json('PUT', route('answers.update',[$answer]), [], ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['content']);


    }
    public function test_own_answer_update()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            "content" => "foo",
            "user_id"=>$user->id
        ]);
        $this->json('PUT', route('answers.update',[$answer]),
            [
                "content" => "bar",
            ]
            , ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'answer updated successfully']);
        $answer->refresh();
        $this->assertEquals('bar', $answer->content);

    }

    public function test_own_answer_delete()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $answer = Answer::factory()->create([
            "user_id"=>$user->id
        ]);

        $this->json('DELETE', route('answers.destroy',[$answer]) , ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
        $this->assertFalse(Answer::whereId($answer->id)->exists());

    }
}
