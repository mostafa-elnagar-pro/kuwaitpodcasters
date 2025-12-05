<?php

namespace App\DataTables;

use Yajra\DataTables\Facades\DataTables;

class ExclusiveEpisodeDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($episode) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$episode->id'></div>";
            })
            ->addColumn('podcaster', function ($episode) {
                $podcaster = $episode->podcaster;
                $route = route('admin.podcasters.show', $podcaster);
                return "<a href='$route'>$podcaster->name</a>";
            })
            ->addColumn('channel', function ($episode) {
                $channel = $episode->channel;
                $route = route('admin.channels.show', $channel);
                return "<a href='$route'>$channel->name</a>";
            })
            ->addColumn('season', function ($episode) {
                $season = $episode->season;
                $route = route('admin.seasons.show', $season);
                return "<a href='$route'>$season->name</a>";
            })
            ->addColumn('image', function ($episode) {
                $imgPath = displayFile($episode->image);
                return "<img src='$imgPath' alt='image' width='35px' />";
            })
            ->addColumn('description', function ($episode) {
                return \Str::limit($episode->description, 50);
            })
            ->addColumn('link', function ($episode) {
                if ($episode->media_source === 'link') {
                    return "<a href='{$episode->link}' target='_blank'>" . __('label.link') . "</a>";
                } else {
                    return "<a href='" . displayFile($episode->link) . "' target='_blank'>" . __('label.link') . "</a>";
                }
            })
            ->addColumn('created_at', function ($episode) {
                return formatDate($episode->created_at);
            })
            ->addColumn('actions', function ($episode) {
                return view("dashboard.pages.exclusive-episodes.datatable.actions", compact('episode'));
            })
            ->rawColumns(['checkbox', 'podcaster', 'channel', 'season', 'image', 'link', 'actions'])
            ->make(true);
    }
}

