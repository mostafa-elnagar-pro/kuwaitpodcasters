<?php

namespace App\Http\Controllers\Api;

use App\Enums\NotificationType;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SeasonRequest;
use App\Http\Resources\SeasonResource;
use App\Http\Services\FcmService;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Models\Season;
use Illuminate\Support\Facades\Gate;


class ChannelSeasonController extends Controller
{
    public function index(Request $request, Channel $channel)
    {
        try {
            $seasons = $channel->seasons()
                ->search($request->search)
                ->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $seasons,
                SeasonResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of index */


    public function store(SeasonRequest $request, Channel $channel)
    {
        try {
            Gate::authorize('create', $channel);

            $data = $request->validated();

            $season = $channel->seasons()->create($data);

            $user = auth()->user();

            /** notification logic */
            defer(function () use ($user, $channel, $season) {
                $followers = $user->followers()->select('users.id', 'fcm_token')->whereNotNull('fcm_token')->get();
                foreach ($followers as $follower) {
                    FcmService::notify(
                        receiver: $follower,
                        title: $user->name,
                        body: 'تم انشاء موسم جديد',
                        data: [
                            'type' => NotificationType::NEW_SEASON,
                            'channel_id' => (string) $channel->id,
                            'season_id' => (string) $season->id,
                            'image' => displayFile($channel->image)
                        ]
                    );
                }
            });
            /** end of notification logic */

            return responseWithData(
                new SeasonResource($season)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of store */


    public function update(SeasonRequest $request, Channel $channel, Season $season)
    {
        try {
            Gate::authorize('update', $channel);

            $data = $request->validated();

            $season->update($data);

            return responseWithData(
                new SeasonResource($season)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of update */


    public function destroy(Channel $channel, Season $season)
    {
        try {
            Gate::authorize('delete', $channel);

            $season->delete();

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of destroy */
}
