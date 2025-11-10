<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::paginate(20);

        if ($request->ajax()) {
            return [
                'html' => view('website.includes.categories-list', compact('categories'))->render(),
                'last_page' => $categories->lastPage()
            ];
        }

        return view('website.categories.index');
    }
    /**end of index */



    public function show($id)
    {
        $category = Category::withCount('podcasts')->findOrFail($id);

        return view('website.categories.show', [
            'category' => $category
        ]);
    }


}
