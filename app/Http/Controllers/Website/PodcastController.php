<?php

namespace App\Http\Controllers\Website;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\PodcastCommentResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PodcastController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:web', only: ['show', 'toggleLike']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        $podcastQuery = match ($request->filter) {
            'most-viewed' => Podcast::mostViewed(),
            'most-recent' => Podcast::latest('id'),
            'season' => Podcast::where('season_id', $request->season_id),
            'category' => (\App\Models\Category::findOrFail($request->category_id))->podcasts(),
            'favourite' => auth()->user()->favourites(),
            'search' => Podcast::search($request->search, 'name', [
                'relation' => 'podcaster',
                'closure' => fn($q) => $q->where('name', 'like', "%$request->search%")
            ])->when(!$request->search, fn($q) => $q->whereRaw('1=0')),
            default => Podcast::query()
        };

        $podcasts = $podcastQuery->withPodcasterInfo()->paginate(8);

        if (request()->ajax()) {
            return [
                'html' => view('website.includes.podcasts-list', ['podcasts' => $podcasts, 'is_search' => $request->filter === 'search'])->render(),
                'last_page' => $podcasts->lastPage(),
            ];
        }

        return view('website.podcasts.index');
    }
    /**end of index*/


    public function show($id)
    {
        $podcast = Podcast::withStats()
            ->with([
                'podcaster:id,name',
                'season',
                'comments' => fn($q) => $q->where('user_id', auth()->id())->with('user:id,name,profile_img')->limit(1),
            ])
            ->withCount('comments')
            ->findOrFail($id);

        $auth_id = auth()->id();
        if (!$podcast->viewedBy($auth_id)) {
            $podcast->views()->attach($auth_id);
        }

        $userComment = null;
        if ($comment = $podcast->comments->first()) {
            $userComment = PodcastCommentResource::make($comment);
        }

        return view('website.podcasts.' . $podcast->media_type, [
            'podcast' => $podcast,
            'user_comment' => $userComment,
        ]);
    }
    /**end of show */


    public function toggleLike($podcast_id)
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

            $color = $podcast->in_favourites ? 'text-danger' : '';
            return "<span>$podcast->likes_count</span><i class='fa fa-heart $color'></i>";
        } catch (\Throwable $e) {
            DB::rollBack();
            return ExceptionHandler::panel($e);
        }
    }
    /**end of toggleLike */

}
