<?php


namespace App\DataTables;


use Yajra\DataTables\DataTables;


class ChannelDatatable
{

    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($channel) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$channel->id'></div>";
            })
            ->addColumn('owner', function ($channel) {
                $owner = $channel->owner;
                $route = route('admin.podcasters.show', $owner);
                return "<a href='$route'>$owner->name</a>";
            })
            ->addColumn('image', function ($channel) {
                $imgPath = displayFile($channel->image);
                return "<img src='$imgPath' alt='image' width='35px' />";
            })
            ->addColumn('created_at', function ($channel) {
                return formatDate($channel->created_at);
            })
            ->addColumn('actions', function ($channel) {
                return view("dashboard.pages.channels.datatable.actions", compact('channel'));
            })
            ->rawColumns(['checkbox', 'owner', 'image', 'actions'])
            ->make(true);
    }
}
