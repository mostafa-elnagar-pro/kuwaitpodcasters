<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ChannelResource;
use App\Http\Resources\PodcastResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Podcast;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $limit = $request->limit ?? 6;

            $collection['sliders'] = SliderResource::collection(
                Slider::limit($limit)->get()
            );

            $collection['podcasters'] = UserResource::collection(
                User::with(['podcasterDetails.category', 'channel'])
                    ->where('type', 'podcaster')
                    ->limit($limit)
                    ->get()
            );

            $collection['most_viewed_podcasts'] = PodcastResource::collection(
                Podcast::mostViewed()->withStats()->limit($limit)->get()
            );

            $collection['channels'] = ChannelResource::collection(
                Channel::limit($limit)->get()
            );

            $collection['latest_podcasts'] = PodcastResource::collection(
                Podcast::withStats()->latest('id')->limit($limit)->get()
            );

            $collection['categories'] = CategoryResource::collection(
                Category::all()
            );

            return responseWithData($collection);
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of __invoke */
}
