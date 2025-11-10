<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ArticleDatatable;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Http\Services\FileService;
use App\Models\Article;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;


class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:articles-read', only: ['index', 'show']),
            new Middleware('permission:articles-create', only: ['create', 'store']),
            new Middleware('permission:articles-update', only: ['edit', 'update']),
            new Middleware('permission:articles-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Article::select('*');

            return ArticleDatatable::setDatatable($data);
        }

        return view('dashboard.pages.articles.index');
    }
    /**end of index */


    public function create()
    {
        return view('dashboard.pages.articles.create');
    }
    /**end of create */


    public function store(ArticleRequest $request)
    {
        try {
            $data = $request->validated();

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'articles');
            }

            $article = Article::create($data);

            return to_route('admin.articles.show', $article)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['image']);
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show(Article $article)
    {
        return view('dashboard.pages.articles.show', [
            'article' => $article
        ]);
    }
    /**end of show */


    public function edit(Article $article)
    {
        return view('dashboard.pages.articles.edit', [
            'article' => $article
        ]);
    }
    /**end of edit */


    public function update(ArticleRequest $request, Article $article)
    {
        try {
            $data = $request->validated();

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'articles', $article->image);
            }

            $article->update($data);

            return to_route('admin.articles.show', $article)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['image']);
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function destroy(Article $article)
    {
        try {
            $article->delete();

            if ($article->image) {
                FileService::unlink($article->image);
            }

            return to_route('admin.articles.index')
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

            Article::destroy($request->items);

            return to_route('admin.articles.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete*/
}
