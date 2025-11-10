<?php

namespace App\Http\Controllers\Website;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastSearchController extends Controller
{
    public function index(Request $request)
    {
        return view('website.podcasts.search', [
            'podcasts' => Podcast::search($request->search)->get()
        ]);
    }
    /**end of index */

    public function search(Request $request)
    {
        try {
            $podcasts = Podcast::select('id', 'name')
                ->search($request->search, 'name', [
                    'relation' => 'podcaster',
                    'closure' => fn($q) => $q->where('name', 'like', "%$request->search%")
                ])->get();

            return response()->json([
                'status' => true,
                'podcasts' => $podcasts
            ]);
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of search */
}
