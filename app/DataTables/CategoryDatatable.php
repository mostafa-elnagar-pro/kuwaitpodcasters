<?php


namespace App\DataTables;

use App\Http\Services\LangService;
use Yajra\DataTables\DataTables;

class CategoryDatatable
{
    public static function setDatatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($q) {
                $search = request('search')['value'] ?? "";
                if (!empty($search)) {
                    $q->where(function ($q) use ($search) {
                        $activeLangs = LangService::active();
                        foreach ($activeLangs as $lang) {
                            $q->orWhere("name->{$lang->abbr}", 'LIKE', "%$search%");
                        }
                    });
                }
            })
            ->addColumn('checkbox', function ($category) {
                return "<div class='form-check form-check-inline'><input class='form-check-input items' name='items[]' type='checkbox' value='$category->id'></div>";
            })
            ->addColumn('name', function ($category) {
                return $category->name;
            })
            ->addColumn('image', function ($category) {
                $imgPath = displayFile($category->image);
                return "<img src='$imgPath' alt='image' width='35px' />";
            })
            ->addColumn('status', function ($category) {
                return view("dashboard.pages.categories.datatable.status-toggler", compact('category'));
            })
            ->addColumn('created_at', function ($category) {
                return formatDate($category->created_at);
            })
            ->addColumn('actions', function ($category) {
                return view("dashboard.pages.categories.datatable.actions", compact('category'));
            })
            ->rawColumns(['checkbox', 'image','status' ,'actions'])
            ->make(true);
    }
}
