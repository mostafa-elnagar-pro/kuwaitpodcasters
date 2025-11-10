<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PodcastResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryPodcastController extends Controller
{
    public function __invoke(Request $request, Category $category)
    {
        try {
            $limit = $request->limit ?? 20;
            // $cacheKey = "category_{$category->id}_podcasts_page_{$request->page}_limit_{$limit}";

            // $podcasts = Cache::remember(
            //     $cacheKey,
            //     60 * 60,
            //     fn() => $category->podcasts()->withStats()->inRandomOrder()->paginate($limit)
            // );

            $podcasts = $category->podcasts()
                ->withPodcasterInfo()
                ->withStats()
                ->search($request->search, 'name', [
                    'relation' => 'podcaster',
                    'closure' => fn($q) => $q->where('name', 'like', "%$request->search%")
                ])
                ->inRandomOrder()
                ->paginate($limit);

            return responseWithPaginatedData(
                $podcasts,
                PodcastResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of __invoke */
}
