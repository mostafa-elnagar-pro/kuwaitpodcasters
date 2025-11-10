<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PodcastResource;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserFavourieController extends Controller
{
    public function index(Request $request)
    {
        try {
            $favourites = auth()->user()->favourites()
                ->withPodcasterInfo()
                ->withStats()
                ->search($request->search, 'name', [
                    'relation' => 'podcaster',
                    'closure' => fn($q) => $q->where('name', 'like', "%$request->search%")
                ])->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $favourites,
                PodcastResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of index */


    public function toggle($podcast_id)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();

            if (!$user->hasLiked($podcast_id)) {
                $user->favourites()->attach($podcast_id);
            } else {
                $user->favourites()->detach($podcast_id);
            }

            $podcast = Podcast::withStats()->findOrFail($podcast_id);

            DB::commit();

            return responseWithData(
                new PodcastResource($podcast)
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return ExceptionHandler::api($e);
        }
    }
    /**end of toggle */


}
