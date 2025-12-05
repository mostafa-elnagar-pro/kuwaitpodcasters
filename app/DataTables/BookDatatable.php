<?php

namespace App\DataTables;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BookDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($book) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$book->id'></div>";
            })
            ->addColumn('name', function ($book) {
                return $book->name;
            })
            ->addColumn('author', function ($book) {
                return $book->author;
            })
            ->addColumn('summary', function ($book) {
                return Str::limit($book->summary, 50);
            })
            ->addColumn('publication_year', function ($book) {
                return $book->publication_year;
            })
            ->addColumn('publisher', function ($book) {
                return $book->publisher;
            })
            ->addColumn('created_at', function ($book) {
                return formatDate($book->created_at);
            })
            ->addColumn('actions', function ($book) {
                return view("dashboard.pages.books.datatable.actions", compact('book'));
            })
            ->rawColumns(['checkbox', 'actions'])
            ->make(true);
    }
}

