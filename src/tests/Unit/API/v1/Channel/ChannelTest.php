<?php

namespace Tests\Unit\API\v1\Channel;


use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Get All Channels List Should Be Accessible
     */

    public function test_get_all_channels_list_should_be_accessible()
    {
        $this->json('GET', route('channel.all'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);

    }

    /**
     * Test Create Channel
     */

    public function test_create_channel_should_be_validated()
    {
        $this->json('POST', route('channel.create'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_create_new_channel()
    {
        $userData = [
            "name" => "laravel",

        ];
        $this->json('POST', route('channel.create'), $userData, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test Update Channel
     */

    public function test_update_channel_should_be_validated()
    {
        $this->json('Put', route('channel.update'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_channel_update()
    {
        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);


        $channelData = ['id' => $channel->id, 'name' => 'jquery'];

        $this->json('Put', route('channel.update'), $channelData, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
        $updatedChannel = Channel::find($channel->id);
        $this->assertEquals('jquery', $updatedChannel->name);

    }


    public function test_delete_channel_should_be_validated()
    {
        $this->json('DELETE', route('channel.delete'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_channel_delete()
    {
        $channel = Channel::factory()->create();

        $this->json('DELETE', route('channel.delete'),['id'=>$channel->id] , ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
    }


}
