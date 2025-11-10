<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::paginate(15);

        if ($request->ajax()) {
            return [
                'html' => view('website.includes.articles-list', compact('articles'))->render(),
                'last_page' => $articles->lastPage()
            ];
        }

        return view('website.articles.index');
    }
    /**end of index */


    public function show(Article $article)
    {
        return view('website.articles.show', [
            'article' => $article,
            'other_articles' => Article::select('id', 'created_at', 'title', 'image')->whereNot('id', $article->id)->inRandomOrder()->take(5)->get()
        ]);
    }
}
