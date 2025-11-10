<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ChannelDatatable;
use App\Helpers\ExceptionHandler;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChannelRequest;
use App\Http\Services\FileService;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;

class ChannelController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:channels-read', only: ['index', 'show']),
            new Middleware('permission:channels-create', only: ['create', 'store']),
            new Middleware('permission:channels-update', only: ['edit', 'update']),
            new Middleware('permission:channels-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Channel::select('*')
                ->with('owner:id,name')
                ->when(
                    $request->podcaster_id !== 'all',
                    fn($q) => $q->whereHas('owner', fn($q) => $q->where('id', $request->podcaster_id))
                );

            return ChannelDatatable::setDatatable($data);
        }

        return view('dashboard.pages.channels.index', [
            'podcasters' => User::where('type', 'podcaster')->select('id', 'email', 'name', 'profile_img')->get(),
        ]);
    }
    /**end of index */


    public function create()
    {
        $podcasters = User::select('id', 'email', 'profile_img')
            ->whereDoesntHave('channel')
            ->where('type', 'podcaster')
            ->get();

        return view('dashboard.pages.channels.create', [
            'podcasters' => $podcasters
        ]);
    }
    /**end of create */


    public function store(ChannelRequest $request)
    {
        try {
            $data = $request->validated();

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'channels');
            }

            $channel = Channel::create($data);

            return to_route('admin.channels.show', $channel)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show($channel_id)
    {
        $channel = Channel::withCount([
            'seasons',
            'podcasts',
            'podcasts as audios_count' => fn($q) => $q->where('media_type', 'audio'),
            'podcasts as videos_count' => fn($q) => $q->where('media_type', 'video')
        ])->with('owner')->findOrFail($channel_id);

        return view('dashboard.pages.channels.show', [
            'channel' => $channel
        ]);
    }
    /**end of show */


    public function edit(Channel $channel)
    {
        return view('dashboard.pages.channels.edit', [
            'channel' => $channel,
        ]);
    }
    /**end of edit */


    public function update(ChannelRequest $request, Channel $channel)
    {
        try {
            $data = $request->validated();

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'channels', $channel->image);
            }

            $channel->update($data);

            return to_route('admin.channels.show', $channel)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function destroy(Channel $channel)
    {
        try {
            $channel->delete();

            if ($channel->image) {
                FileService::unlink($channel->image);
            }

            return to_route('admin.channels.index')
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

            $channels = Channel::whereIn('id', $request->items)->get();

            Channel::destroy($channels->pluck('id')->all());

            foreach ($channels as $channel) {
                if ($channel->image) {
                    FileService::unlink($channel->image);
                }
            }

            return to_route('admin.channels.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete */
}
