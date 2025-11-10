<?php

namespace App\DataTables;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ArticleDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($article) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$article->id'></div>";
            })
            ->addColumn('image', function ($article) {
                $imgPath = displayFile($article->image);
                return "<img src='$imgPath' alt='image' width='35px' />";
            })
            ->addColumn('title', function ($article) {
                return $article->title;
            })
            ->addColumn('short_body', function ($article) {
                return $article->short_body;
            })
            ->addColumn('created_at', function ($article) {
                return formatDate($article->created_at);
            })
            ->addColumn('actions', function ($article) {
                return view("dashboard.pages.articles.datatable.actions", compact('article'));
            })
            ->rawColumns(['checkbox', 'image', 'actions'])
            ->make(true);
    }
}