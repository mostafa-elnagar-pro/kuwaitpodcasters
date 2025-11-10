<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDatatable;
use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Services\FileService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller implements HasMiddleware
{
    protected $categoryQuery;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:categories-read', only: ['index', 'show']),
            new Middleware('permission:categories-create', only: ['create', 'store']),
            new Middleware('permission:categories-update', only: ['edit', 'update']),
            new Middleware('permission:categories-delete', only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function __construct()
    {
        $this->categoryQuery= Category::withoutGlobalScopes();
    }
    /**end of __construct */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->categoryQuery->select('*');

            return CategoryDatatable::setDatatable($data);
        }

        return view('dashboard.pages.categories.index');
    }
    /** end of index */


    public function create()
    {
        return view('dashboard.pages.categories.create');
    }
    /** end of create */


    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->validated();

            $data['image'] = FileService::uploadImage($data['image'], 'category');

            $category = Category::create($data);

            forgetCachedSettings();

            return to_route('admin.categories.show', $category)
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['image']);
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /** end of store */


    public function show($category_id)
    {
        return view('dashboard.pages.categories.show', [
            'category' => $this->categoryQuery->findOrFail($category_id)
        ]);
    }
    /**end of show */


    public function edit($category_id)
    {
        return view('dashboard.pages.categories.edit', [
            'category' => $this->categoryQuery->findOrFail($category_id)
        ]);
    }
    /**end of edit */


    public function update(CategoryRequest $request, $category_id)
    {
        $category= $this->categoryQuery->findOrFail($category_id);
        
        try {
            $data = $request->validated();

            if (isset($data['image'])) {
                $data['image'] = FileService::uploadImage($data['image'], 'category', $category->image);
            }

            $category->update($data);

            forgetCachedSettings();

            return to_route('admin.categories.show', $category)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($data['image']);
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function updateStatus(Request $request, $category_id)
    {
        $category= $this->categoryQuery->findOrFail($category_id);
        
        try {
            $category->update(['is_active'=> $request->boolean('is_active')]);

            forgetCachedSettings();

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of updateStatus */


    public function destroy($category_id)
    {
        $category= $this->categoryQuery->findOrFail($category_id);

        try {
            $category->delete();

            if ($category->image) {
                FileService::unlink($category->image);
            }

            forgetCachedSettings();

            return to_route('admin.categories.index')
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

            $categories = $this->categoryQuery->whereIn('id', $request->items)->get();

            Category::destroy($categories->pluck('id')->all());

            foreach ($categories as $category) {
                if ($category->image) {
                    FileService::unlink($category->image);
                }
            }

            forgetCachedSettings();

            return to_route('admin.categories.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete */
}
