<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('path.lang', function () {
            return base_path('lang');
        });

        $this->app->singleton('settings', function ($app) {
            return \App\Http\Services\SettingsService::web();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();

        Paginator::useBootstrapFive();

        view()->composer([
            'dashboard.pages.articles.create',
            'dashboard.pages.articles.edit',
            'dashboard.pages.books.create',
            'dashboard.pages.books.edit',
            'dashboard.pages.languages.edit',
            'dashboard.pages.categories.create',
            'dashboard.pages.categories.edit',
            'dashboard.pages.keywords.create',
            'dashboard.pages.keywords.edit',
            'dashboard.pages.settings.trans_text_form',
            'dashboard.pages.settings.trans_texts',
        ], function ($view) {
            $view->with('activeLangs', \App\Http\Services\LangService::active());
        });


        /** performance debugging */

        // app()->terminating(function () {
        // Log::info('Memory usage: ' . memory_get_usage() . ' bytes');
        // });

        // Listen to database queries and count them
        // DB::listen(function ($query) {
        //     static $queryCount = 0;
        //     $queryCount++;


            //Log total queries count at the end of the request
            // app()->terminating(function () use ($queryCount) {
                // Log::info('Total number of queries: ' . $queryCount);
            // });
        // });
    }
}
