<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SeasonDatatable;
use App\Helpers\ExceptionHandler;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeasonRequest;
use App\Models\Channel;
use App\Models\Season;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SeasonController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:seasons-read', only: ['index', 'show']),
            new Middleware('permission:seasons-create', only: ['create', 'store']),
            new Middleware('permission:seasons-update', only: ['edit', 'update']),
            new Middleware('permission:seasons-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Season::select('*')
                ->withCount('podcasts')
                ->with([
                    'channel' => fn($q) => $q->with('owner:id,name')->select('id', 'user_id', 'name')
                ])
                ->when(
                    $request->podcaster_id !== 'all',
                    fn($q) => $q->whereHas('channel.owner', fn($q) => $q->where('id', $request->podcaster_id))
                )
                ->filter($request->channel_id, 'channel_id');

            return SeasonDatatable::setDatatable($data);
        }

        return view('dashboard.pages.seasons.index', [
            'podcasters' => User::where('type', 'podcaster')->select('id', 'email', 'profile_img')->get(),
            'channels' => Channel::select('id', 'name', 'image')->get(),
        ]);
    }
    /**end of index */

    public function getChannelSeasons(Request $request)
    {
        $channel = User::select('id')
            ->with([
                'channel' => function ($q) {
                    $q->select('id', 'user_id', 'name')
                        ->with('seasons:channel_id,id,name');
                }
            ])
            ->findOrFail($request->podcaster_id)
            ->channel;


        return [
            'channel_options' => View::make('dashboard.includes.channel-filter-options', ['channel' => $channel])->render(),
            'season_options' => View::make('dashboard.includes.season-filter-options', ['seasons' => $channel->seasons])->render()
        ];
    }


    public function create()
    {
        return view('dashboard.pages.seasons.create', [
            'channels' => Channel::select('id', 'name')->get()
        ]);
    }
    /**end of create */


    public function store(SeasonRequest $request)
    {
        try {
            $data = $request->validated();

            $season = Season::create($data);

            return to_route('admin.seasons.show', $season)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show($season_id)
    {
        $season = Season::with([
            'channel' => fn($q) => $q->with('owner:id,name')->select('id', 'user_id', 'name')
        ])->findOrFail($season_id);

        return view('dashboard.pages.seasons.show', [
            'season' => $season
        ]);
    }
    /**end of show */


    public function edit(Season $season)
    {
        return view('dashboard.pages.seasons.edit', [
            'season' => $season,
            'channels' => Channel::select('id', 'name')->get()
        ]);
    }
    /**end of edit */


    public function update(SeasonRequest $request, Season $season)
    {
        try {
            $data = $request->validated();

            $season->update($data);

            return to_route('admin.seasons.show', $season)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function destroy(Season $season)
    {
        try {
            $season->delete();

            return to_route('admin.seasons.index')
                ->with('success', __('messages.successDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedDelete'));
        }
    }
    /**end of destroy */


    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*' => 'numeric'
            ]);

            Season::destroy($request->items);

            return to_route('admin.seasons.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete */
}
