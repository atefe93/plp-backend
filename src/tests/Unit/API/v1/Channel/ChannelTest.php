<?php

namespace Tests\Unit\API\v1\Channel;


use App\Models\Channel;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{


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
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        $this->actingAs($user)->json('POST', route('channel.create'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_create_new_channel()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        $Data = [
            "name" => "laravel",

        ];
        $this->actingAs($user)->json('POST', route('channel.create'), $Data, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test Update Channel
     */

    public function test_update_channel_should_be_validated()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        $this->actingAs($user)->json('Put', route('channel.update'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_channel_update()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);


        $channelData = ['id' => $channel->id, 'name' => 'jquery'];

        $this->actingAs($user)->json('Put', route('channel.update'), $channelData, ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
        $updatedChannel = Channel::find($channel->id);
        $this->assertEquals('jquery', $updatedChannel->name);

    }


    public function test_delete_channel_should_be_validated()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        $this->actingAs($user)->json('DELETE', route('channel.delete'), ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_channel_delete()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create();

        $this->actingAs($user)->json('DELETE', route('channel.delete'),['id'=>$channel->id] , ['Accept' => 'application/json'])
            ->assertStatus(Response::HTTP_OK);
    }


}
