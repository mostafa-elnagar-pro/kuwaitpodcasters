<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDatatable;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Helpers\ExceptionHandler;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Services\FileService;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:users-read', only: ['index', 'show']),
            new Middleware('permission:users-create', only: ['create', 'store']),
            new Middleware('permission:users-update', only: ['edit', 'update']),
            new Middleware('permission:users-delete', only: ['destroy', 'bulkDelete']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*')
                ->where('type', 'user')
                ->filter($request->status, 'status');

            return UserDatatable::setDatatable($data);
        }

        return view('dashboard.pages.users.index');
    }
    /** end of index */


    public function create()
    {
        return view('dashboard.pages.users.create', [
            'countries' => Country::select('id', 'name', 'code')->orderBy('name')->get()
        ]);
    }
    /**end of create */


    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create(array_merge($data, [
                'type' => 'user',
                'password' => bcrypt($data['password']),
                'profile_img' => isset($data['profile_img']) ? FileService::uploadImage($data['profile_img'], 'profile') : null
            ]));

            return to_route('admin.users.show', $user)
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
        $user = User::where('id', $id)->firstOrFail();

        return view('dashboard.pages.users.show', [
            'user' => $user
        ]);
    }
    /**end of show */


    public function edit($id)
    {
        $user = User::with('country')
            ->where('id', $id)
            ->firstOrFail();

        $user->phone = substr($user->phone, strlen($user->country->code), strlen($user->phone));
        $user->country = $user->country->code . '@' . $user->country->id;

        return view('dashboard.pages.users.edit', [
            'user' => $user,
            'countries' => Country::all()
        ]);
    }
    /**end of edit */


    public function update(UserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $data = array_filter($request->validated());

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            if (isset($data['profile_img'])) {
                $data['profile_img'] = FileService::uploadImage($data['profile_img'], 'profile', $user->profile_img);
            }

            $user->update($data);

            DB::commit();

            return to_route('admin.users.show', $user)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['profile_img']);
            DB::rollBack();
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */



    public function destroy(User $user)
    {
        try {
            $user->delete();

            if ($user->profile_img) {
                FileService::unlink($user->profile_img);
            }

            return to_route('admin.users.index')
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

            $users = User::whereIn('id', $request->items)->get();

            User::destroy($users->pluck('id')->all());

            foreach ($users as $user) {
                if ($user->profile_img) {
                    FileService::unlink($user->profile_img);
                }
            }

            return to_route('admin.users.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete */
}
