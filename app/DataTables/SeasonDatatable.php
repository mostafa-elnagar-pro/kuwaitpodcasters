<?php


namespace App\DataTables;


use Yajra\DataTables\DataTables;


class SeasonDatatable
{

    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($season) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$season->id'></div>";
            })
            ->addColumn('podcaster', function ($season) {
                $owner = $season->channel->owner;
                $route = route('admin.podcasters.show', $owner);
                return "<a href='$route'>$owner->name</a>";
            })
            ->addColumn('channel', function ($season) {
                $channel = $season->channel;
                $route = route('admin.channels.show', $channel);
                return "<a href='$route'>$channel->name</a>";
            })
            ->addColumn('podcasts_count', function ($season) {
                return $season->podcasts_count ?? 0;
            })
            ->addColumn('created_at', function ($season) {
                return formatDate($season->created_at);
            })
            ->addColumn('actions', function ($season) {
                return view("dashboard.pages.seasons.datatable.actions", compact('season'));
            })
            ->rawColumns(['checkbox', 'channel', 'podcaster', 'actions'])
            ->make(true);
    }
}
