<?php


namespace App\DataTables;


use Yajra\DataTables\DataTables;


class PodcastDatatable
{

    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($podcast) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$podcast->id'></div>";
            })
            ->addColumn('podcaster', function ($podcast) {
                $podcaster = $podcast->podcaster;
                $route = route('admin.podcasters.show', $podcaster);
                return "<a href='$route'>$podcaster->name</a>";
            })
            ->addColumn('channel', function ($podcast) {
                $channel = $podcast->channel;
                $route = route('admin.channels.show', $channel);
                return "<a href='$route'>$channel->name</a>";
            })
            ->addColumn('season', function ($podcast) {
                $season = $podcast->season;
                $route = route('admin.seasons.show', $season);
                return "<a href='$route'>$season->name</a>";
            })
            ->addColumn('image', function ($podcast) {
                $imgPath = displayFile($podcast->image);
                return "<img src='$imgPath' alt='image' width='35px' />";
            })
            ->addColumn('status', function ($podcast) {
                return view("dashboard.pages.podcasts.datatable.status-toggler", compact('podcast'));
            })
            ->addColumn('created_at', function ($podcast) {
                return formatDate($podcast->created_at);
            })
            ->addColumn('actions', function ($podcast) {
                return view("dashboard.pages.podcasts.datatable.actions", compact('podcast'));
            })
            ->rawColumns(['checkbox', 'podcaster', 'channel', 'season', 'image', 'actions'])
            ->make(true);
    }
}
