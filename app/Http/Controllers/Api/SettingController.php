<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ExceptionHandler;
use App\Http\Services\LangService;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    public function __invoke(Request $request)
    {
        $activeLangs = (LangService::active())->pluck('abbr')->toArray();
        $lang = in_array($request->lang, $activeLangs) ? $request->lang : 'ar';
        $cacheKey = "mobile_settings_data_{$lang}";

        app()->setLocale($lang);

        try {
            $collection = \App\Http\Services\SettingsService::mobile($cacheKey);

            return responseWithData($collection);
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of index */

}


