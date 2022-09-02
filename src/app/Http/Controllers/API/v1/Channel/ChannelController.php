<?php

namespace App\Http\Controllers\API\v1\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    public function getAllChannelsList()
    {
        $all_channels=resolve(ChannelRepository::class)->all();
        return response()->json($all_channels,Response::HTTP_OK);
    }

    /**
     * Create New Channel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewChannel(Request $request)
    {
        $request->validate([
            'name'=>['required']
        ]);

        //Insert Channel To Database
        resolve(ChannelRepository::class)->create($request);

        return response()->json([
            'message'=>'Channel created successfully'
        ],Response::HTTP_CREATED);
    }

    /**
     * Update Channel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateChannel(Request $request)
    {
        $request->validate([
            'name'=>['required']
        ]);
        //Update Channel In Database
        resolve(ChannelRepository::class)->update($request);

        return response()->json([
            'message'=>'Channel updated successfully'
        ],Response::HTTP_OK);

    }

    /**
     * Delete Channel(s)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleteChannel(Request $request)
    {
        $request->validate([
            'id'=>['required']
        ]);
        //Delete Channel In Database
        resolve(ChannelRepository::class)->delete($request);

        return response()->json([
            'message'=>'Channel deleted successfully'
        ],Response::HTTP_OK);

    }




}
