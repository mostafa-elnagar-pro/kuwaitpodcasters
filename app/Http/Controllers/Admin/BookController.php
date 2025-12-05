<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BookDatatable;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Models\Book;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;


class BookController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:books-read', only: ['index', 'show']),
            new Middleware('permission:books-create', only: ['create', 'store']),
            new Middleware('permission:books-update', only: ['edit', 'update']),
            new Middleware('permission:books-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::select('*');

            return BookDatatable::setDatatable($data);
        }

        return view('dashboard.pages.books.index');
    }
    /**end of index */


    public function create()
    {
        return view('dashboard.pages.books.create');
    }
    /**end of create */


    public function store(BookRequest $request)
    {
        try {
            $data = $request->validated();

            $book = Book::create($data);

            return to_route('admin.books.show', $book)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show(Book $book)
    {
        return view('dashboard.pages.books.show', [
            'book' => $book
        ]);
    }
    /**end of show */


    public function edit(Book $book)
    {
        return view('dashboard.pages.books.edit', [
            'book' => $book
        ]);
    }
    /**end of edit */


    public function update(BookRequest $request, Book $book)
    {
        try {
            $data = $request->validated();

            $book->update($data);

            return to_route('admin.books.show', $book)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function destroy(Book $book)
    {
        try {
            $book->delete();

            return to_route('admin.books.index')
                ->with('success', __('messages.successDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedDelete'));
        }
    }
    /**end of destroy */


    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*' => 'numeric'
            ]);

            Book::destroy($request->items);

            return to_route('admin.books.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete*/
}

