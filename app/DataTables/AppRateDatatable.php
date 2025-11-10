<?php


namespace App\DataTables;


use Yajra\DataTables\DataTables;


class AppRateDatatable
{

    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($app_rate) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$app_rate->id'></div>";
            })
            ->addColumn('email', function ($app_rate) {
                $user = $app_rate->user;
                $route = route("admin.{$user->type}s.show", $user);
                return "<a href='$route'>$user->email</a>";
            })
            ->addColumn('created_at', function ($app_rate) {
                return formatDate($app_rate->created_at);
            })
            ->addColumn('actions', function ($app_rate) {
                return view("dashboard.pages.app_rates.datatable.actions", compact('app_rate'));
            })
            ->rawColumns(['email', 'checkbox', 'actions'])
            ->make(true);
    }
}
