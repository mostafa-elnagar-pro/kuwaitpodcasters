<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PodcastResource;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function __invoke(Request $request, $filter)
    {
        try {
            $podcastQuery = match ($filter) {
                'most-viewed' => Podcast::mostViewed(),
                'most-recent' => Podcast::latest('id'),
                default => auth()->user()->podcasts()
            };

            $podcasts = $podcastQuery
                ->withStats()
                ->with('channel:id', 'season:id')
                ->search($request->search, 'name', [
                    'relation' => 'podcaster',
                    'closure' => fn($q) => $q->where('name', 'like', "%$request->search%")
                ])->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $podcasts,
                PodcastResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /** end of index */
}
