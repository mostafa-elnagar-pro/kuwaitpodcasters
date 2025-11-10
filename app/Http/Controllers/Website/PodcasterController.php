<?php

namespace App\Http\Controllers\Website;

use App\Enums\NotificationType;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\User;

class PodcasterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:web', only: ['toggleFollow']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        $podcasters = User::where('type', 'podcaster')->paginate(20);

        if ($request->ajax()) {
            return [
                'html' => view('website.includes.podcasters-list', compact('podcasters'))->render(),
                'last_page' => $podcasters->lastPage()
            ];
        }

        return view('website.podcasters.index');
    }
    /**end of index */

    public function show($id)
    {
        $podcaster = User::withFollows()
            ->with([
                'podcasterDetails',
                'category' => fn($q) => $q->withoutGlobalScopes(),
                'channel.seasons'
            ])
            ->where('type', 'podcaster')
            ->findOrFail($id);

        return view('website.podcasters.show', [
            'podcaster' => $podcaster
        ]);
    }
    /**end of show */


    public function toggleFollow($id)
    {
        try {
            $follower = auth()->user();
            $podcaster = User::withFollows()->findOrFail($id);

            if ($podcaster->type !== 'podcaster' || $podcaster->id === $follower->id) {
                return errorResponse();
            }

            if ($podcaster->isFollowedBy($follower->id)) {
                $podcaster->followers()->detach($follower->id);

                $followersCount = $podcaster->followers_count - 1;
                $followCountView = $followersCount > 0 ? $followersCount . ' ' . __kw('followers', 'متابع') : null;
                $buttonView = __kw('follow', 'متابعة');
            } else {
                $podcaster->followers()->attach($follower->id);

                $followCountView = $podcaster->followers_count + 1 . ' ' . __kw('followers', 'متابع');
                $buttonView = __kw('unfollow', 'إلغاء المتابعة');

                // send notification
                defer(function () use ($podcaster, $follower) {
                    if ($podcaster->fcm_token) {
                        /** notification logic */
                        \App\Http\Services\FcmService::notify(
                            receiver: $podcaster,
                            title: $follower->name,
                            body: 'Started to follow you',
                            data: [
                                'type' => NotificationType::NEW_FOLLOWER,
                                'user_id' => (string) $follower->id,
                                'image' => displayFile($follower->profile_img)
                            ]
                        );
                        /** end of notification logic */
                    }
                });
            }

            return [
                'button_text' => $buttonView,
                'follow_count' => $followCountView
            ];
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of toggleFollow */
}
