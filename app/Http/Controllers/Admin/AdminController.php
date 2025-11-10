<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Controllers\Controller;
use App\Helpers\ExceptionHandler;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:admins-read', only: ['index']),
            new Middleware('permission:admins-create', only: ['create', 'store']),
            new Middleware(['isSuperAdmin', 'permission:admins-update'], only: ['edit', 'update']),
            new Middleware(['isSuperAdmin', 'permission:admins-delete'], only: ['destroy']),
        ];
    }
    /**end of middleware */


    public function index()
    {
        return view('dashboard.pages.admins.index', [
            'admins' => Admin::paginate(10),
        ]);
    }
    /**end of index */


    public function create()
    {
        return view('dashboard.pages.admins.create', [
            'roles' => Role::all()
        ]);
    }
    /**end of create */


    public function store(AdminRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($data['password']);

            $admin = Admin::create($data);

            $admin->addRole($data['role']);

            return to_route('admin.admins.show', $admin)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show(Admin $admin)
    {
        $authUser = auth()->user();

        if (
            $authUser->isAbleTo('admins-read') || $authUser->id === $admin->id
        ) {
            return view('dashboard.pages.admins.show', ['admin' => $admin]);
        }

        abort(403, __('messages.unauthorizedAction'));
    }
    /**end of show */


    public function edit(Admin $admin)
    {
        return view('dashboard.pages.admins.edit', [
            'admin' => $admin,
            'roles' => Role::all()
        ]);
    }
    /**end of edit */


    public function update(AdminRequest $request, Admin $admin)
    {
        try {
            $data = array_filter($request->validated());

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            $admin->update($data);

            $admin->syncRoles([$data['role']]);

            Cache::forget("laratrust_roles_for_admins_$admin->id");

            return to_route('admin.admins.show', $admin)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function destroy(Admin $admin)
    {
        try {
            $admin->delete();

            Cache::forget("laratrust_roles_for_admins_$admin->id");

            return to_route('admin.admins.index')
                ->with('success', __('messages.successDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedDelete'));
        }
    }
    /**end of destroy */
}
