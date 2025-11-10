<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:home-read', only: ['__invoke']),
        ];
    }

    public function __invoke()
    {
        return view('dashboard.pages.index', [
            'widgets' => $this->fetchWidgetsData(),
            'activePodcasters' => $this->fetchPodcastStats()
        ]);
    }
    /**end of __invoke */


    private function fetchPodcastStats(): array
    {
        return \App\Models\User::select('id', 'name', 'profile_img')
            ->where('type', 'podcaster')
            ->withExists('podcasts')
            ->withCount('podcasts')
            ->with(['podcasts' => fn($q) => $q->select('id', 'user_id')->withCount('views', 'likes')])
            ->orderBy('podcasts_count', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'user_img' => displayFile($user->profile_img),
                    'podcasts' => $user->podcasts->count(),
                    'likes' => $user->podcasts->sum('likes_count'),
                    'views' => $user->podcasts->sum('views_count'),

                ];
            })
            ->toArray();

    }


    private function fetchWidgetsData()
    {
        return DB::selectOne("
        SELECT 
            (SELECT COUNT(*) FROM admins) AS admins_count,
            (SELECT COUNT(*) FROM users WHERE type = 'podcaster') AS podcasters_count,
            (SELECT COUNT(*) FROM users WHERE type = 'user') AS users_count,
            (SELECT COUNT(*) FROM channels) AS channels_count,
            (SELECT COUNT(*) FROM seasons) AS seasons_count,
            (SELECT COUNT(*) FROM podcasts) AS podcasts_count,
            (SELECT COUNT(*) FROM podcasts WHERE media_type = 'video') AS videos_count,
            (SELECT COUNT(*) FROM podcasts WHERE media_type = 'audio') AS audios_count
        ");
    }

}
