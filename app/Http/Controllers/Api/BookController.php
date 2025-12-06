<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        try {
            $locale = app()->getLocale();

            $books = Book::query()
                ->when($request->search, function ($query, $search) use ($locale) {
                    $query->where(function ($q) use ($search, $locale) {
                        $q->where("name->$locale", 'like', "%$search%")
                            ->orWhere("author->$locale", 'like', "%$search%")
                            ->orWhere("summary->$locale", 'like', "%$search%")
                            ->orWhere("publisher->$locale", 'like', "%$search%");
                    });
                })
                ->latest('id')
                ->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $books,
                BookResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }


    public function store(BookRequest $request)
    {
        try {
            $book = Book::create(
                $request->validated()
            );

            return responseWithData(
                new BookResource($book)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }


    public function show(Book $book)
    {
        try {
            return responseWithData(
                new BookResource($book)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }


    public function update(BookRequest $request, Book $book)
    {
        try {
            $book->update(
                $request->validated()
            );

            return responseWithData(
                new BookResource($book)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }


    public function destroy(Book $book)
    {
        try {
            $book->delete();

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
}
