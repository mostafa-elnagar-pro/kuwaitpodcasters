<?php


namespace App\DataTables;

use Yajra\DataTables\DataTables;

class UserDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($user) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$user->id'></div>";
            })
            ->addColumn('type', function ($user) {
                return __("label.$user->type");
            })
            ->addColumn('status', function ($user) {
                $color = match ($user->status) { 'active' => 'success', 'pending' => 'warning', default => 'danger'};
                $label = __("label.$user->status");
                return "<span class='badge bg-$color'>$label</span>";
            })
            ->addColumn('profile_img', function ($user) {
                $imgPath = displayFile($user->profile_img);
                return "<img src='$imgPath' alt='profile' width='35px' />";
            })
            ->addColumn('created_at', function ($user) {
                return formatDate($user->created_at);
            })
            ->addColumn('actions', function ($user) {
                return view("dashboard.pages.users.datatable.actions", compact('user'));
            })
            ->rawColumns(['checkbox', 'status', 'profile_img', 'actions'])
            ->make(true);
    }
}
