<?php


namespace App\DataTables;


use Yajra\DataTables\DataTables;


class FeedbackDatatable
{

    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($feedback) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$feedback->id'></div>";
            })
            ->addColumn('created_at', function ($feedback) {
                return formatDate($feedback->created_at);
            })
            ->addColumn('actions', function ($feedback) {
                return view("dashboard.pages.feedbacks.datatable.actions", compact('feedback'));
            })
            ->rawColumns(['checkbox', 'actions'])
            ->make(true);
    }
}
