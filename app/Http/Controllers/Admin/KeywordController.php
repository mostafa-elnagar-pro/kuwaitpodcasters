<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\KeywordDatatable;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\Admin\KeywordRequest;
use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:keywords-read', only: ['index']),
            new Middleware('permission:keywords-create', only: ['create', 'store']),
            new Middleware('permission:keywords-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Keyword::select('*')
                ->filter($request->type, 'type');

            return KeywordDatatable::setDatatable($data);
        }

        return view('dashboard.pages.keywords.index');
    }
    /**end of index */


    public function create()
    {
        return view('dashboard.pages.keywords.create');
    }
    /**end of create */


    public function store(KeywordRequest $request)
    {
        try {
            $data = $request->validated();

            $keyword = Keyword::create($data);

            forgetCachedSettings();

            return to_route('admin.keywords.show', $keyword)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }

    }
    /**end of store */


    public function show(Keyword $keyword)
    {
        return view('dashboard.pages.keywords.show', [
            'keyword' => $keyword
        ]);
    }
    /**end of show */


    public function edit(Keyword $keyword)
    {
        return view('dashboard.pages.keywords.edit', [
            'keyword' => $keyword
        ]);
    }
    /**end of edit */


    public function update(KeywordRequest $request, Keyword $keyword)
    {
        try {
            $data = $request->validated();

            $keyword->update($data);

            forgetCachedSettings();

            return to_route('admin.keywords.show', $keyword)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function destroy(Keyword $keyword)
    {
        try {
            $keyword->delete();

            forgetCachedSettings();

            return to_route('admin.keywords.index')
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

            Keyword::destroy($request->items);

            forgetCachedSettings();

            return to_route('admin.keywords.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete */


}
