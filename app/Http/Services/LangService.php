<?php


namespace App\Http\Services;

use App\Models\Language;
use Illuminate\Support\Facades\Cache;

class LangService
{
    public static function active()
    {
        return Cache::remember('active_langs', 60 * 60 * 24, function () {
            return Language::where('is_active', true)->get();
        });
    }
}
