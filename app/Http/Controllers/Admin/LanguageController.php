<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ExceptionHandler;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LanguageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:languages-read', only: ['index', 'show']),
            new Middleware('permission:languages-create', only: ['create', 'store']),
            new Middleware(['permission:languages-update'], only: ['edit', 'update']),
            new Middleware(['permission:languages-delete'], only: ['destroy']),
        ];
    }
    /**end of middleware */


    public function index()
    {
        return view('dashboard.pages.languages.index', [
            'languages' => Language::paginate(10),
        ]);
    }
    /**end of index */


    public function create()
    {
        return view('dashboard.pages.languages.create', [
            'existingLangs' => Language::select('id', 'abbr')->get()->pluck('abbr')
        ]);
    }
    /**end of create */


    public function store(Request $request)
    {
        try {
            $langList = [];
            foreach ($request->langs as $lang) {
                $lang = (array) json_decode($lang);
                $lang['name'] = json_encode(['en' => $lang['name']]);
                $lang['created_at'] = now();

                $langList[] = $lang;
            }

            Language::insert($langList);

            Cache::forget('active_langs');
            forgetCachedSettings();

            return to_route('admin.languages.index')
                ->with('success', __('messages.successCreate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedCreate'));
        }
    }
    /**end of store */


    public function show(Language $language)
    {
        return view('dashboard.pages.languages.show', [
            'language' => $language
        ]);
    }
    /**end of show */


    public function edit(Language $language)
    {
        return view('dashboard.pages.languages.edit', [
            'language' => $language,
        ]);
    }
    /**end of edit */


    public function update(LanguageRequest $request, Language $language)
    {
        try {
            $data = $request->validated();

            $language->update($data);

            Cache::forget('active_langs');
            forgetCachedSettings();

            return to_route('admin.languages.show', $language)
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function destroy(Language $language)
    {
        try {
            $language->delete();

            Cache::forget('active_langs');
            forgetCachedSettings();

            return to_route('admin.languages.index')
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

            Language::destroy($request->items);

            Cache::forget('active_langs');
            forgetCachedSettings();

            return to_route('admin.languages.index')
                ->with('success', __('messages.successMultiDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedMultiDelete'));
        }
    }
    /**end of bulkDelete*/
}
