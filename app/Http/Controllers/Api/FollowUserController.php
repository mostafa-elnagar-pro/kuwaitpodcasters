<?php

namespace App\Http\Controllers\Api;

use App\Enums\NotificationType;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Services\FcmService;
use App\Models\User;


class FollowUserController extends Controller
{
    public function __invoke(User $user)
    {
        try {
            $follower = auth()->user();

            if ($user->type !== 'podcaster' || $user->id === $follower->id) {
                return errorResponse();
            }

            if ($user->isFollowedBy($follower->id)) {
                $user->followers()->detach($follower->id);
            } else {
                $user->followers()->attach($follower->id);

                defer(function () use ($user, $follower) {
                    if ($user->fcm_token) {
                        /** notification logic */
                        FcmService::notify(
                            receiver: $user,
                            title: $follower->name,
                            body: 'قام بمتابعتك',
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

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of toggleFollow */
}
