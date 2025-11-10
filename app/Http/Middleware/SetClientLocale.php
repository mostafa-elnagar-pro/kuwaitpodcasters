<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetClientLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeLangs = (\App\Http\Services\LangService::active())->pluck('abbr')->toArray();

        $locale = $request->query('lang', 'ar');

        if (in_array($locale, $activeLangs)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
