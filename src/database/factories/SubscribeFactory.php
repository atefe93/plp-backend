<?php

namespace Database\Factories;

use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscribeFactory extends Factory
{
    protected $model = Subscribe::class;
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'thread_id' => Thread::factory()->create()->id,
        ];
    }
}
