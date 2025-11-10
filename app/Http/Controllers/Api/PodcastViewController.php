<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Models\Podcast;

class PodcastViewController extends Controller
{
    public function __invoke(Podcast $podcast)
    {
        try {
            $user_id = auth()->id();

            if (!$podcast->viewedBy($user_id)) {
                $podcast->views()->attach($user_id);
            }

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
}
