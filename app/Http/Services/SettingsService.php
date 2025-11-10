<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Cache;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\LanguageResource;
use App\Models\Category;
use App\Models\Country;
use App\Models\Keyword;
use App\Models\Language;
use App\Models\Setting;


class SettingsService
{
    public static function mobile($cacheKey)
    {
        return Cache::remember($cacheKey, 60 * 60 * 24 * 30, function () {
            $list['general'] = Setting::all()->map(function ($item) {

                if ($item->type === 'trans_text') {
                    $content = $item->trans_value;
                } elseif (in_array($item->type, ['audio', 'video', 'image'])) {
                    $content = displayFile($item->value);
                } else {
                    $content = $item->value;
                }

                return [
                    'key' => $item->key,
                    'content' => $content
                ];
            })->values()->toArray();

            $list['countries'] = CountryResource::collection(Country::all());
            $list['categories'] = CategoryResource::collection(Category::all());
            $list['langs'] = LanguageResource::collection(Language::where('is_active', true)->get());
            $list['keywords'] = Keyword::where('type', 'mobile')->get()->pluck('value', 'key')->toArray();

            return $list;
        });
    }
    /**end of mobile */


    public static function web()
    {
        $currentLang = request('lang') ?? 'ar';

        $activeLangs = (LangService::active())->pluck('abbr')->toArray();
        $lang = in_array($currentLang, $activeLangs) ? $currentLang : 'ar';
        $cacheKey = "web_settings_data_{$lang}";

        app()->setLocale($lang);

        return Cache::remember($cacheKey, 60 * 60 * 24 * 30, function () {
            $list['general'] = Setting::all()->map(function ($item) {

                if ($item->type === 'trans_text') {
                    $content = $item->trans_value;
                } elseif (in_array($item->type, ['audio', 'video', 'image'])) {
                    $content = $item->value;
                } else {
                    $content = $item->value;
                }

                return [
                    $item->key => $content
                ];
            })->collapse()->toArray();

            $list['countries'] = Country::all();
            $list['categories'] = Category::all();
            $list['active_langs'] = Language::where('is_active', true)->get();
            $list['keywords'] = Keyword::where('type', 'web')->get()->pluck('value', 'key')->toArray();

            return $list;
        });
    }
    /**end of web */
}