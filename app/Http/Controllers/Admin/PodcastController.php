<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\DataTables\PodcastDatatable;
use App\Helpers\ExceptionHandler;
use App\Http\Services\FileService;
use App\Models\Category;
use App\Models\Podcast;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PodcastController extends Controller implements HasMiddleware
{
    protected $podcastQuery;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:podcasts-read', only: ['index', 'show']),
            new Middleware('permission:podcasts-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function __construct()
    {
        $this->podcastQuery = Podcast::withoutGlobalScopes();
    }
    /**end of __construct */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->podcastQuery->select('*')
                ->with('season:id,name', 'channel:id,name', 'podcaster:id,name')
                ->filter($request->podcaster_id, 'user_id')
                ->filter($request->channel_id, 'channel_id')
                ->filter($request->season_id, 'season_id')
                ->when($request->category_id !== 'all', fn($q) => $q->whereHas('podcaster.category', fn($q) => $q->where('categories.id', $request->category_id)));

            return PodcastDatatable::setDatatable($data);
        }

        return view('dashboard.pages.podcasts.index', [
            'podcasters' => User::where('type', 'podcaster')->select('id', 'name', 'email', 'profile_img')->get(),
            'categories' => Category::select('id', 'name', 'image')->get(),
        ]);
    }
    /**end of index */


    public function show($podcast_id)
    {
        $podcast = $this->podcastQuery->with('season:id,name', 'channel:id,name', 'podcaster:id,name')->findOrFail($podcast_id);

        return view('dashboard.pages.podcasts.show', [
            'podcast' => $podcast
        ]);
    }
    /**end of show */


    public function updateStatus(Request $request, $podcast_id)
    {
        $podcast = $this->podcastQuery->findOrFail($podcast_id);

        try {
            $podcast->update(['is_active' => $request->boolean('is_active')]);

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of updateStatus */


    public function destroy(Podcast $podcast)
    {
        try {
            $podcast->delete();

            if ($podcast->image) {
                FileService::unlink($podcast->image);
            }

            if ($podcast->media_source === 'fileupload') {
                FileService::unlink($podcast->link);
            }

            return to_route('admin.podcasts.index')
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

            $podcasts = $this->podcastQuery->whereIn('id', $request->items)->get();

            Podcast::destroy($podcasts->pluck('id')->all());

            foreach ($podcasts as $podcast) {
                FileService::unlink($podcast->image);

                if ($podcast->media_source === 'fileupload') {
                    FileService::unlink($podcast->link);
                }
            }

            return to_route('admin.podcasts.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }

    /**end of bulkDelete */
}
