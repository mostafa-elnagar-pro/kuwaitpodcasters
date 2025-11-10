<?php


namespace App\DataTables;

use Yajra\DataTables\DataTables;

class PermissionDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($permission) {
                return when(
                    !in_array($permission->group, ['admins', 'roles', 'permissions']),
                    "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$permission->id'></div>"
                );
            })
            ->addColumn('created_at', function ($permission) {
                return formatDate($permission->created_at);
            })
            ->addColumn('actions', function ($permission) {
                return view("dashboard.pages.permissions.datatable.actions", compact('permission'));
            })
            ->rawColumns(['checkbox', 'actions'])
            ->make(true);
    }
}
