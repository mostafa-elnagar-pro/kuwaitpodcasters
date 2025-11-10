<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\DataTables\PermissionDatatable;
use App\Helpers\ExceptionHandler;
use App\Http\Requests\Admin\PermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:permissions-read', only: ['index']),
            new Middleware('permission:permissions-create', only: ['create', 'store']),
            new Middleware('permission:permissions-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::select('*');

            return PermissionDatatable::setDatatable($data);
        }

        return view('dashboard.pages.permissions.index');
    }
    /**end of index */


    public function create()
    {
        return view('dashboard.pages.permissions.create');
    }
    /**end of create */


    public function store(PermissionRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['group'] = strtolower($data['group']);

            $permissions = [];
            foreach ($data['options'] as $key) {
                $permissions[] = Permission::create([
                    'group' => $data['group'],
                    'name' => $data['group'] . '-' . $key,
                    'display_name' => ucfirst($key) . ' ' . Str::headline($data['group']),
                    'created_at' => now()
                ])->id;
            }

            $adminRole = Role::first();

            $adminRole->givePermissions($permissions);

            DB::commit();

            Cache::forget("laratrust_permissions_for_role_$adminRole->id");

            return to_route('admin.permissions.index')
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function destroy($id)
    {
        try {
            $permission = Permission::with(['roles' => fn($q) => $q->select('id')])->findOrFail($id);

            $permission->delete();

            foreach ($permission->roles as $role) {
                Cache::forget("laratrust_permissions_for_role_$role->id");
            }

            return to_route('admin.permissions.index')
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

            Permission::destroy($request->items);

            foreach (Role::select('id')->get() as $role) {
                Cache::forget("laratrust_permissions_for_role_$role->id");
            }

            return to_route('admin.permissions.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete*/
}
