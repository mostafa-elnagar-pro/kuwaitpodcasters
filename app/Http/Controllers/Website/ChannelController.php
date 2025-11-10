<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index(Request $request)
    {
        $channels = Channel::select('id', 'name', 'image')->paginate(20);

        if ($request->ajax()) {
            return [
                'html' => view('website.includes.channels-list', compact('channels'))->render(),
                'last_page' => $channels->lastPage()
            ];
        }

        return view('website.channels.index');
    }
    /**end of index */


    public function show($id)
    {
        $channel = Channel::withCount('seasons', 'podcasts')
            ->withOwnerInfo()
            ->with('seasons:id,name,channel_id')
            ->findOrFail($id);

        return view('website.channels.show', [
            'channel' => $channel
        ]);
    }
    /**end of show */
}
