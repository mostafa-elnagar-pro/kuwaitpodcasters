<?php

namespace App\Http\Controllers\Api;

use App\Enums\NotificationType;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PodcastRequest;
use App\Http\Resources\PodcastResource;
use App\Http\Services\FcmService;
use App\Http\Services\FileChunkingService;
use App\Http\Services\FileService;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Models\Podcast;
use App\Models\Season;
use Illuminate\Support\Facades\Gate;

class SeasonPodcastController extends Controller
{
    public function index(Request $request, Channel $channel, Season $season)
    {
        try {
            $podcasts = $season->podcasts()
                ->withStats()
                ->search($request->search, 'name', [
                    'relation' => 'podcaster',
                    'closure' => fn($q) => $q->where('name', 'like', "%$request->search%")
                ])
                ->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $podcasts,
                PodcastResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of index */


    public function store(PodcastRequest $request, Channel $channel, Season $season)
    {
        try {
            Gate::authorize('create', $channel);

            $data = $request->validated();

            if ($data['media_source'] === 'fileupload') {
                $response = FileChunkingService::videoOrAudio($data);
                if (!$response->processed) {
                    return responseWithData($response);
                }

                $data['link'] = FileService::uploadVideoOrAudio($response->new_file, "podcast-{$data['media_type']}s");
            }

            $podcast = Podcast::create(array_merge($data, [
                'user_id' => auth()->id(),
                'season_id' => $season->id,
                'channel_id' => $channel->id,
                'image' => FileService::uploadImage($data['image'], 'podcast-images')
            ]));

            $user = auth()->user();

            /** notification logic */
            defer(function () use ($channel, $season, $podcast, $user) {
                $followers = $user->followers()->select('users.id', 'fcm_token')->whereNotNull('fcm_token')->get();
                foreach ($followers as $follower) {
                    FcmService::notify(
                        receiver: $follower,
                        title: $user->name,
                        body: 'تم اضافة بودكاست جديد',
                        data: [
                            'type' => NotificationType::NEW_PODCAST,
                            'channel_id' => (string) $channel->id,
                            'season_id' => (string) $season->id,
                            'podcast_id' => (string) $podcast->id,
                            'image' => displayFile($podcast->image)
                        ]
                    );
                }
            });
            /** end of notification logic */

            return responseWithData(
                new PodcastResource($podcast)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of store */

    public function update(PodcastRequest $request, Channel $channel, Season $season, Podcast $podcast)
    {
        try {
            Gate::authorize('update', $channel);

            $data = $request->validated();

            if (isset($data['media_source'])) {
                if ($data['media_source'] === 'fileupload') {
                    $response = FileChunkingService::videoOrAudio($data);
                    if (!$response->processed) {
                        return responseWithData($response);
                    }

                    $data['link'] = FileService::uploadVideoOrAudio($response->new_file, "podcast-{$data['media_type']}s");
                }

                if ($podcast->media_source === 'fileupload') {
                    FileService::unlink($podcast->link);
                }
            }

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'podcast-images', $podcast->image);
            }

            $podcast->update($data);

            return responseWithData(
                new PodcastResource($podcast)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of update (not used yet) */


    public function destroy(Channel $channel, Season $season, Podcast $podcast)
    {
        try {
            Gate::authorize('delete', $channel);

            $podcast->delete();

            FileService::unlink($podcast->image);

            if ($podcast->media_source === 'fileupload') {
                FileService::unlink($podcast->link);
            }

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of destroy */
}
