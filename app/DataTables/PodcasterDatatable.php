<?php


namespace App\DataTables;

use Yajra\DataTables\DataTables;

class PodcasterDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($podcaster) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$podcaster->id'></div>";
            })
            ->addColumn('podcasts', function ($podcaster) {
                return view("dashboard.pages.podcasters.datatable.podcasts", compact('podcaster'));
            })
            ->addColumn('channel', function ($podcaster) {
                return view("dashboard.pages.podcasters.datatable.channel", compact('podcaster'));
            })
          
            ->addColumn('profile_img', function ($podcaster) {
                $imgPath = displayFile($podcaster->profile_img);
                return "<img src='$imgPath' alt='profile' width='35px' />";
            })
            ->addColumn('status', function ($podcaster) {
                return view("dashboard.pages.podcasters.datatable.status-toggler", compact('podcaster'));
            })
            ->addColumn('created_at', function ($podcaster) {
                return formatDate($podcaster->created_at);
            })
            ->addColumn('actions', function ($podcaster) {
                return view("dashboard.pages.podcasters.datatable.actions", compact('podcaster'));
            })
            ->rawColumns(['checkbox', 'status', 'profile_img', 'actions'])
            ->make(true);
    }
}
