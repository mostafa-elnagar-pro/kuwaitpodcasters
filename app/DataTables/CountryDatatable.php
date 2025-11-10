<?php


namespace App\DataTables;

use Yajra\DataTables\DataTables;

class CountryDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($country) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$country->id'></div>";
            })
            ->addColumn('flag', function ($country) {
                return "<span class='fs-3 flag-icon flag-icon-$country->flag'></span>";
            })
            ->addColumn('created_at', function ($country) {
                return formatDate($country->created_at);
            })
            ->addColumn('actions', function ($country) {
                return view("dashboard.pages.countries.datatable.actions", compact('country'));
            })
            ->rawColumns(['checkbox', 'flag', 'actions'])
            ->make(true);
    }
}
