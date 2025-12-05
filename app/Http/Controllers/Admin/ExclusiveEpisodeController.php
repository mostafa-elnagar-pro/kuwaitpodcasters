<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ExclusiveEpisodeDatatable;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExclusiveEpisodeRequest;
use App\Http\Services\FileService;
use App\Models\Category;
use App\Models\ExclusiveEpisode;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExclusiveEpisodeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:exclusive-episodes-read', only: ['index', 'show']),
            new Middleware('permission:exclusive-episodes-create', only: ['create', 'store']),
            new Middleware('permission:exclusive-episodes-update', only: ['edit', 'update']),
            new Middleware('permission:exclusive-episodes-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ExclusiveEpisode::select('*')
                ->with('season:id,name', 'channel:id,name', 'podcaster:id,name')
                ->filter($request->podcaster_id, 'user_id')
                ->filter($request->channel_id, 'channel_id')
                ->filter($request->season_id, 'season_id')
                ->when($request->category_id !== 'all', fn($q) => $q->whereHas('podcaster.category', fn($q) => $q->where('categories.id', $request->category_id)));

            return ExclusiveEpisodeDatatable::setDatatable($data);
        }

        return view('dashboard.pages.exclusive-episodes.index', [
            'podcasters' => User::where('type', 'podcaster')->select('id', 'name', 'email', 'profile_img')->get(),
            'categories' => Category::select('id', 'name', 'image')->get(),
        ]);
    }
    /**end of index */


    public function create()
    {
        return view('dashboard.pages.exclusive-episodes.create', [
            'podcasters' => User::where('type', 'podcaster')->select('id', 'name', 'email', 'profile_img')->get(),
        ]);
    }
    /**end of create */


    public function getChannelSeasons(Request $request)
    {
        $user = User::select('id')
            ->with([
                'channel' => function ($q) {
                    $q->select('id', 'user_id', 'name', 'image')
                        ->with('seasons:channel_id,id,name');
                }
            ])
            ->findOrFail($request->podcaster_id);

        $channel = $user->channel;

        if (!$channel) {
            return response()->json([
                'channel_options' => '<option value="" disabled>' . __('label.select_channel') . '</option>',
                'season_options' => '<option value="" disabled>' . __('label.select_season') . '</option>'
            ]);
        }

        $channelOptions = '<option value="' . $channel->id . '" data-img="' . displayFile($channel->image) . '">' . $channel->name . '</option>';
        $seasonOptions = '<option value="" disabled>' . __('label.select_season') . '</option>';
        
        foreach ($channel->seasons ?? [] as $season) {
            $seasonOptions .= '<option value="' . $season->id . '">' . $season->name . '</option>';
        }

        return response()->json([
            'channel_options' => $channelOptions,
            'season_options' => $seasonOptions
        ]);
    }
    /**end of getChannelSeasons */


    public function store(ExclusiveEpisodeRequest $request)
    {
        try {
            $data = $request->validated();

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'exclusive-episodes');
            }

            if ($data['media_source'] === 'fileupload' && isset($data['media_file'])) {
                if ($data['media_type'] === 'video') {
                    $data['link'] = FileService::uploadVideoOrAudio($data['media_file'], 'exclusive-episodes-videos');
                } else {
                    $data['link'] = FileService::uploadVideoOrAudio($data['media_file'], 'exclusive-episodes-audios');
                }
                unset($data['media_file']);
            }

            $episode = ExclusiveEpisode::create($data);

            return to_route('admin.exclusive-episodes.show', $episode)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['image'] ?? null);
            rollbackUploadedFile($data['link'] ?? null);
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show(ExclusiveEpisode $exclusiveEpisode)
    {
        $exclusiveEpisode->load('season:id,name', 'channel:id,name', 'podcaster:id,name');
        return view('dashboard.pages.exclusive-episodes.show', [
            'episode' => $exclusiveEpisode
        ]);
    }
    /**end of show */


    public function edit(ExclusiveEpisode $exclusiveEpisode)
    {
        return view('dashboard.pages.exclusive-episodes.edit', [
            'episode' => $exclusiveEpisode,
            'podcasters' => User::where('type', 'podcaster')->select('id', 'name', 'email', 'profile_img')->get(),
        ]);
    }
    /**end of edit */


    public function update(ExclusiveEpisodeRequest $request, ExclusiveEpisode $exclusiveEpisode)
    {
        try {
            $data = $request->validated();

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'exclusive-episodes', $exclusiveEpisode->image);
            }

            if ($data['media_source'] === 'fileupload' && isset($data['media_file'])) {
                if ($data['media_type'] === 'video') {
                    $data['link'] = FileService::uploadVideoOrAudio($data['media_file'], 'exclusive-episodes-videos', $exclusiveEpisode->link);
                } else {
                    $data['link'] = FileService::uploadVideoOrAudio($data['media_file'], 'exclusive-episodes-audios', $exclusiveEpisode->link);
                }
                unset($data['media_file']);
            }

            $exclusiveEpisode->update($data);

            return to_route('admin.exclusive-episodes.show', $exclusiveEpisode)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['image'] ?? null);
            rollbackUploadedFile($data['link'] ?? null);
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function destroy(ExclusiveEpisode $exclusiveEpisode)
    {
        try {
            $exclusiveEpisode->delete();

            if ($exclusiveEpisode->image) {
                FileService::unlink($exclusiveEpisode->image);
            }

            if ($exclusiveEpisode->media_source === 'fileupload') {
                FileService::unlink($exclusiveEpisode->link);
            }

            return to_route('admin.exclusive-episodes.index')
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
                'items.*' => 'numeric',
            ]);

            $episodes = ExclusiveEpisode::whereIn('id', $request->items)->get();

            ExclusiveEpisode::destroy($episodes->pluck('id')->all());

            foreach ($episodes as $episode) {
                FileService::unlink($episode->image);

                if ($episode->media_source === 'fileupload') {
                    FileService::unlink($episode->link);
                }
            }

            return to_route('admin.exclusive-episodes.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete*/
}

