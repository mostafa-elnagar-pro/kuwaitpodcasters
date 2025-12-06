<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ExclusiveEpisodeRequest;
use App\Http\Resources\ExclusiveEpisodeResource;
use App\Http\Services\FileService;
use App\Models\Channel;
use App\Models\ExclusiveEpisode;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExclusiveEpisodeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $episodes = ExclusiveEpisode::query()
                ->with(['season:id,name', 'channel:id,name', 'podcaster:id,name'])
                ->filter($request->channel_id, 'channel_id')
                ->filter($request->season_id, 'season_id')
                ->search($request->search, 'name')
                ->latest('id')
                ->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $episodes,
                ExclusiveEpisodeResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }


    public function store(ExclusiveEpisodeRequest $request)
    {
        try {
            $data = $request->validated();

            $channel = Channel::findOrFail($data['channel_id']);
            Gate::authorize('update', $channel);

            Season::where('channel_id', $channel->id)->findOrFail($data['season_id']);

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'exclusive-episodes');
            }

            if ($data['media_source'] === 'fileupload' && isset($data['media_file'])) {
                $folder = $data['media_type'] === 'video'
                    ? 'exclusive-episodes-videos'
                    : 'exclusive-episodes-audios';

                $data['link'] = FileService::uploadVideoOrAudio($data['media_file'], $folder);
                unset($data['media_file']);
            }

            $episode = ExclusiveEpisode::create(array_merge($data, [
                'user_id' => auth()->id(),
            ]));

            return responseWithData(
                new ExclusiveEpisodeResource($episode)
            );
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['image'] ?? null);
            rollbackUploadedFile($data['link'] ?? null);
            return ExceptionHandler::api($e);
        }
    }


    public function show(ExclusiveEpisode $exclusiveEpisode)
    {
        try {
            $exclusiveEpisode->load('season:id,name', 'channel:id,name', 'podcaster:id,name');

            return responseWithData(
                new ExclusiveEpisodeResource($exclusiveEpisode)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }


    public function update(ExclusiveEpisodeRequest $request, ExclusiveEpisode $exclusiveEpisode)
    {
        try {
            $data = $request->validated();

            $channel = Channel::findOrFail($data['channel_id']);
            Gate::authorize('update', $channel);

            Season::where('channel_id', $channel->id)->findOrFail($data['season_id']);

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'exclusive-episodes', $exclusiveEpisode->image);
            }

            if ($data['media_source'] === 'fileupload' && isset($data['media_file'])) {
                $folder = $data['media_type'] === 'video'
                    ? 'exclusive-episodes-videos'
                    : 'exclusive-episodes-audios';

                $data['link'] = FileService::uploadVideoOrAudio($data['media_file'], $folder, $exclusiveEpisode->link);
                unset($data['media_file']);
            } elseif ($exclusiveEpisode->media_source === 'fileupload' && $exclusiveEpisode->link && $data['media_source'] === 'link') {
                FileService::unlink($exclusiveEpisode->link);
            }

            $exclusiveEpisode->update($data);

            return responseWithData(
                new ExclusiveEpisodeResource($exclusiveEpisode)
            );
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['image'] ?? null);
            rollbackUploadedFile($data['link'] ?? null);
            return ExceptionHandler::api($e);
        }
    }


    public function destroy(ExclusiveEpisode $exclusiveEpisode)
    {
        try {
            Gate::authorize('delete', $exclusiveEpisode->channel);

            $exclusiveEpisode->delete();

            if ($exclusiveEpisode->image) {
                FileService::unlink($exclusiveEpisode->image);
            }

            if ($exclusiveEpisode->media_source === 'fileupload') {
                FileService::unlink($exclusiveEpisode->link);
            }

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
}
