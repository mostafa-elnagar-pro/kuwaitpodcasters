<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PodcasterDatatable;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PodcasterRequest;
use App\Http\Services\FileService;
use App\Models\Category;
use App\Models\Country;
use App\Models\PodcasterDetails;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PodcasterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:podcasters-read', only: ['index', 'show']),
            new Middleware('permission:podcasters-create', only: ['create', 'store']),
            new Middleware(['permission:podcasters-update'], only: ['edit', 'update']),
            new Middleware(['permission:podcasters-delete'], only: ['destroy', 'bulkDelete']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*')
                ->withCount([
                    'podcasts',
                    'podcasts as audios_count' => fn($q) => $q->where('media_type', 'audio'),
                    'podcasts as videos_count' => fn($q) => $q->where('media_type', 'video')
                ])
                ->with('channel:id,name,user_id')
                ->where('type', 'podcaster')
                ->filter($request->status, 'status');

            return PodcasterDatatable::setDatatable($data);
        }

        return view('dashboard.pages.podcasters.index');
    }
    /** end of index */


    public function create()
    {
        return view('dashboard.pages.podcasters.create', [
            'categories' => Category::select('id', 'name')->orderBy('name')->get(),
            'countries' => Country::select('id', 'name', 'code')->orderBy('name')->get()
        ]);
    }
    /**end of create */


    public function store(PodcasterRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $podcaster = User::create(array_merge($data, [
                'type' => 'podcaster',
                'password' => bcrypt($data['password']),
                'profile_img' => isset($data['profile_img']) ? FileService::uploadImage($data['profile_img'], 'profile') : null
            ]));

            $podcaster->podcasterDetails()->create($data);

            DB::commit();

            return to_route('admin.podcasters.show', $podcaster)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['profile_img']);
            DB::rollBack();
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show($id)
    {
        $podcaster = User::withCount([
            'podcasts',
            'podcasts as audios_count' => fn($q) => $q->where('media_type', 'audio'),
            'podcasts as videos_count' => fn($q) => $q->where('media_type', 'video')
        ])->with([
                    'podcasterDetails.category',
                    'channel' => fn($q) => $q->select('id', 'name', 'user_id')->withCount('seasons')
                ])
            ->where(['id' => $id, 'type' => 'podcaster'])
            ->firstOrFail();


        return view('dashboard.pages.podcasters.show', [
            'podcaster' => $podcaster
        ]);
    }
    /**end of show */


    public function edit($id)
    {
        $podcaster = User::with(['country', 'podcasterDetails.category'])
            ->where('id', $id)
            ->firstOrFail();

        $podcaster->phone = substr($podcaster->phone, strlen($podcaster->country->code), strlen($podcaster->phone));
        $podcaster->country = $podcaster->country->code . '@' . $podcaster->country->id;

        return view('dashboard.pages.podcasters.edit', [
            'podcaster' => $podcaster,
            'categories' => Category::all(),
            'countries' => Country::all()
        ]);
    }
    /**end of edit */


    public function update(PodcasterRequest $request, User $podcaster)
    {
        try {
            DB::beginTransaction();

            $data = array_filter($request->validated());

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            if (isset($data['profile_img'])) {
                $data['profile_img'] = FileService::uploadImage($data['profile_img'], 'profile', $podcaster->profile_img);
            }

            $podcaster->update($data);

            $attributes = (new PodcasterDetails())->getFillable();
            $filteredData = collect($data)->only($attributes)->toArray();

            $podcaster->podcasterDetails()->update($filteredData);

            DB::commit();

            return to_route('admin.podcasters.show', $podcaster)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['profile_img']);
            DB::rollBack();
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function updateStatus(Request $request, $podcaster_id)
    {
        $podcaster = User::where('type', 'podcaster')->findOrFail($podcaster_id);

        try {
            $podcaster->update([
                'status' => $request->boolean('is_active') ? 'active' : 'inactive'
            ]);

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of updateStatus */


    public function destroy(User $podcaster)
    {
        try {
            $podcaster->delete();

            if ($podcaster->profile_img) {
                FileService::unlink($podcaster->profile_img);
            }

            return to_route('admin.podcasters.index')
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

            $podcasters = User::whereIn('id', $request->items)->get();

            User::destroy($podcasters->pluck('id')->all());

            foreach ($podcasters as $podcaster) {
                if ($podcaster->profile_img) {
                    FileService::unlink($podcaster->profile_img);
                }
            }

            return to_route('admin.podcasters.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete */
}
