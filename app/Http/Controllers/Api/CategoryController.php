<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $categories = Category::query()
                ->search($request->search)
                ->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $categories,
                CategoryResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of __invoke */

    public function toggleStatus(Category $category)
    {
        try {
            $category->update(['status' => !$category->status]);
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating status'], 500);
        }
    }
}
