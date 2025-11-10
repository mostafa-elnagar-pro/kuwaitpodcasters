<?php

namespace App\Http\Controllers\Api;

use App\Enums\NotificationType;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChannelRequest;
use App\Http\Resources\ChannelResource;
use App\Http\Services\FcmService;
use App\Http\Services\FileService;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ChannelController extends Controller
{
    public function index(Request $request)
    {
        try {
            $channels = Channel::withOwnerInfo()
                ->search($request->search)
                ->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $channels,
                ChannelResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of index */


    public function store(ChannelRequest $request)
    {
        try {
            $user = auth()->user();

            if ($user->channel()->exists() || $user->type !== 'podcaster') {
                return errorResponse();
            }

            $data = $request->validated();

            $data['image'] = FileService::uploadImage($data['image'], 'channels');

            $channel = $user->channel()->create($data);

            /** notification logic */
            defer(function () use ($channel, $user) {
                $followers = $user->followers()->select('users.id', 'fcm_token')->whereNotNull('fcm_token')->get();
                foreach ($followers as $follower) {
                    FcmService::notify(
                        receiver: $follower,
                        title: $user->name,
                        body: 'تم إنشاء قناة جديدة',
                        data: [
                            'type' => NotificationType::NEW_CHANNEL,
                            'channel_id' => (string) $channel->id,
                            'image' => displayFile($channel->image)
                        ]
                    );
                }
            });
            /** end of notification logic */

            return responseWithData(
                new ChannelResource($channel)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of store */


    public function show($channel_id)
    {
        try {
            $channel = Channel::withOwnerInfo()->findOrFail($channel_id);

            return responseWithData(
                new ChannelResource($channel)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of show */


    public function update(ChannelRequest $request, $channel_id)
    {
        try {
            $data = $request->validated();

            $channel = Channel::withOwnerInfo()->findOrFail($channel_id);

            Gate::authorize('update', $channel);

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'channels', $channel->image);
            }

            $channel->update($data);

            return responseWithData(
                new ChannelResource($channel)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of update */


    public function destroy(Channel $channel)
    {
        try {
            Gate::authorize('delete', $channel);

            $channel->delete();

            if ($channel->image) {
                FileService::unlink($channel->image);
            }

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of destroy */
}
