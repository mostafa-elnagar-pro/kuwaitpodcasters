<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('website.index', [
            'sliders' => \App\Models\Slider::select('image')->get()->pluck('image'),
            'channels' => \App\Models\Channel::inRandomOrder()->limit(15)->get(),
            'most_viewed_podcasts' => \App\Models\Podcast::mostViewed()->withPodcasterInfo()->limit(8)->get(),
            'most_recent_podcasts' => \App\Models\Podcast::latest('id')->withPodcasterInfo()->limit(8)->get(),
            'categories' => \App\Models\Category::limit(15)->get(),
            'featured_podcasters' => \App\Models\User::where('type', 'podcaster')->limit(15)->get(),
            'app_reviews' => \App\Models\AppRate::with('user:id,type,name,profile_img')->latest('created_at')->limit(3)->get(),
            'articles' => \App\Models\Article::latest('id')->limit(3)->get(),
        ]);
    }
}
