<?php


namespace App\DataTables;

use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class KeywordDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($keyword) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$keyword->id'></div>";
            })
            ->addColumn('value', function ($keyword) {
                return $keyword->value;
            })
            ->addColumn('actions', function ($keyword) {
                return view("dashboard.pages.keywords.datatable.actions", compact('keyword'));
            })
            ->rawColumns(['checkbox', 'actions'])
            ->make(true);
    }
}
