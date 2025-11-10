<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:roles-read', only: ['index', 'show']),
            new Middleware('permission:roles-create', only: ['create', 'store']),
            new Middleware(['isSuperAdminRole', 'permission:roles-update'], only: ['edit', 'update']),
            new Middleware(['isSuperAdminRole', 'permission:roles-delete'], only: ['destroy']),
        ];
    }
    /**end of middleware */


    public function index()
    {
        return view('dashboard.pages.roles.index', [
            'roles' => Role::latest('id')->paginate(10),
        ]);
    }
    /**end of index */


    public function create()
    {
        $permissionList = Permission::all()->groupBy('group')->map(function ($permissions) {
            return $permissions->map(function ($permission) {
                [$group_name, $permission_name] = explode('-', $permission->name) + [null, null];
                return (object) [
                    'id' => $permission->id,
                    'group' => $group_name,
                    'name' => $permission_name,
                ];
            });
        });

        return view('dashboard.pages.roles.create', [
            'permissionList' => $permissionList
        ]);
    }
    /**end of create */


    public function store(RoleRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $role = Role::create($data);

            $role->syncPermissions($data['permissions']);

            DB::commit();

            return to_route('admin.roles.show', $role)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show(Role $role)
    {
        return view('dashboard.pages.roles.show', [
            'role' => $role
        ]);
    }
    /**end of show */


    public function edit(Role $role)
    {
        $permissionList = Permission::all()->groupBy('group')->map(function ($permissions) {
            return $permissions->map(function ($permission) {
                [$group_name, $permission_name] = explode('-', $permission->name) + [null, null];
                return (object) [
                    'id' => $permission->id,
                    'group' => $group_name,
                    'name' => $permission_name,
                ];
            });
        });

        return view('dashboard.pages.roles.edit', [
            'role' => $role,
            'role_permission_ids' => $role->permissions->pluck('id')->toArray(),
            'permissionList' => $permissionList
        ]);
    }
    /**end of edit */


    public function update(RoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $role->update($data);

            $role->syncPermissions($data['permissions']);

            DB::commit();

            Cache::forget("laratrust_permissions_for_role_$role->id");

            return to_route('admin.roles.show', $role)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /** end of update */


    public function destroy(Role $role)
    {
        try {
            $role->delete();

            Cache::forget("laratrust_permissions_for_role_$role->id");
            Cache::forget("laratrust_roles_for_admins_$role->id");

            return to_route('admin.roles.index')
                ->with('success', __('messages.successDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedDelete'));
        }
    }
    /** end of destroy */
}
