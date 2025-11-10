<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\Admin\SliderRequest;
use App\Helpers\ExceptionHandler;
use App\Http\Services\FileService;
use App\Models\Slider;


class SliderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:sliders-read', only: ['index', 'show']),
            new Middleware('permission:sliders-create', only: ['create', 'store']),
            new Middleware('permission:sliders-delete', only: ['destroy']),
        ];
    }
    /**end of middleware */


    public function index()
    {
        return view('dashboard.pages.sliders.index', [
            'sliders' => Slider::paginate(10),
        ]);
    }
    /**end of index */


    public function create()
    {
        return view('dashboard.pages.sliders.create');
    }
    /**end of create */


    public function store(SliderRequest $request)
    {
        try {
            $data = $request->validated();

            $data['image'] = FileService::uploadImage($data['image'], 'sliders');

            Slider::create($data);

            return to_route('admin.sliders.index')
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show(Slider $slider)
    {
        return view('dashboard.pages.sliders.show', [
            'slider' => $slider
        ]);
    }
    /**end of show */


    public function destroy(Slider $slider)
    {
        try {
            $slider->delete();

            if ($slider->image) {
                FileService::unlink($slider->image);
            }

            return to_route('admin.sliders.index')
                ->with('success', __('messages.successDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedDelete'));
        }
    }
    /**end of destroy */
}
