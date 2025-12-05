<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppRateController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExclusiveEpisodeController;
use App\Http\Controllers\Admin\ChannelController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\PodcastController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\KeywordController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\NotifyUserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PodcasterController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/dashboard',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        'as' => 'admin.',
    ],
    function () {
        Route::group(['middleware' => 'auth:admin'], function () {
            Route::get('/', HomeController::class)->name('home');

            Route::resource('roles', RoleController::class);

            Route::delete('permissions/bulk-delete', [PermissionController::class, 'bulkDelete'])->name('permissions.bulkDelete');
            Route::resource('permissions', PermissionController::class)->except(['show', 'edit', 'update']);

            Route::resource('admins', AdminController::class);

            Route::delete('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulkDelete');
            Route::resource('users', UserController::class);

            Route::put('podcasters/{podcaster}/update-status', [PodcasterController::class, 'updateStatus'])->name('podcasters.updateStatus');
            Route::delete('podcasters/bulk-delete', [PodcasterController::class, 'bulkDelete'])->name('podcasters.bulkDelete');
            Route::resource('podcasters', PodcasterController::class);

            Route::group(['controller' => NotifyUserController::class, 'as' => 'users.'], function () {
                Route::post('users/{user}/notify', 'notify')->name('notify');
                Route::post('users/notify-all', 'notifyAll')->name('notifyAll');
            });

            Route::delete('channels/bulk-delete', [ChannelController::class, 'bulkDelete'])->name('channels.bulkDelete');
            Route::resource('channels', ChannelController::class);

            Route::delete('seasons/bulk-delete', [SeasonController::class, 'bulkDelete'])->name('seasons.bulkDelete');
            Route::get('channel-seasons', [SeasonController::class, 'getChannelSeasons'])->name('channel.seasons');
            Route::resource('seasons', SeasonController::class);

            Route::put('podcasts/{podcast}/update-status', [PodcastController::class, 'updateStatus'])->name('podcasts.updateStatus');
            Route::delete('podcasts/bulk-delete', [PodcastController::class, 'bulkDelete'])->name('podcasts.bulkDelete');
            Route::resource('podcasts', PodcastController::class)->only(['index', 'show', 'destroy']);

            Route::delete('articles/bulk-delete', [ArticleController::class, 'bulkDelete'])->name('articles.bulkDelete');
            Route::resource('articles', ArticleController::class);

            Route::delete('books/bulk-delete', [BookController::class, 'bulkDelete'])->name('books.bulkDelete');
            Route::resource('books', BookController::class);

            Route::delete('exclusive-episodes/bulk-delete', [ExclusiveEpisodeController::class, 'bulkDelete'])->name('exclusive-episodes.bulkDelete');
            Route::get('exclusive-episodes-channel-seasons', [ExclusiveEpisodeController::class, 'getChannelSeasons'])->name('exclusive-episodes.channelSeasons');
            Route::resource('exclusive-episodes', ExclusiveEpisodeController::class);

            Route::delete('countries/bulk-delete', [CountryController::class, 'bulkDelete'])->name('countries.bulkDelete');
            Route::resource('countries', CountryController::class)->except('edit', 'update');

            Route::put('categories/{category}/update-status', [CategoryController::class, 'updateStatus'])->name('categories.updateStatus');
            Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');
            Route::resource('categories', CategoryController::class);

            Route::delete('languages/bulk-delete', [LanguageController::class, 'bulkDelete'])->name('languages.bulkDelete');
            Route::resource('languages', LanguageController::class);

            Route::delete('sliders/bulk-delete', [SliderController::class, 'bulkDelete'])->name('sliders.bulkDelete');
            Route::resource('sliders', SliderController::class);

            Route::delete('keywords/bulk-delete', [KeywordController::class, 'bulkDelete'])->name('keywords.bulkDelete');
            Route::resource('keywords', KeywordController::class);

            Route::group(['prefix' => 'settings', 'controller' => SettingController::class, 'as' => 'settings.'], function () {
                Route::get('{type}', 'show')->where('type', 'text|trans_text|image|audio|video')->name('index');
                Route::put('setting/texts', 'updateTextRecords')->where('type', 'text|trans_text|image|audio|video')->name('updateTexts');
                Route::put('settings/{setting}', 'updateSingle')->name('update');
                Route::delete('settings/{setting}', 'destroy')->name('delete');
            });

            Route::delete('feedbacks/bulk-delete', [FeedbackController::class, 'bulkDelete'])->name('feedbacks.bulkDelete');
            Route::resource('feedbacks', FeedbackController::class)->except('store', 'update');

            Route::delete('app_rates/bulk-delete', [AppRateController::class, 'bulkDelete'])->name('app_rates.bulkDelete');
            Route::resource('app_rates', AppRateController::class)->except('store', 'update');

            Route::post('ckeditor-upload-media', function () {
                return \App\Http\Services\FileService::uploadImage(request('upload'), 'ckeditor-media', returnJson: true);
            })->name('ckeditor.uploadMedia');

            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        });


        Route::group(['controller' => AuthController::class, 'middleware' => 'guest:admin'], function () {
            Route::get('login', 'showLoginForm')->name('login.show');
            Route::post('login', 'login')->name('login');
        });
    }
);







Route::get('generate-sitemap', function () {
    $sitemap = Spatie\Sitemap\Sitemap::create();

    // Add static routes
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/'));
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/channels'));

    // Dynamic: Add podcasts routes
    $podcasts = \App\Models\Podcast::all();
    foreach ($podcasts as $podcast) {
        $sitemap->add(Spatie\Sitemap\Tags\Url::create("/podcasts/{$podcast->id}"));
    }

    // Add podcast index page
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/podcasts'));

    // Dynamic: Add podcasters routes
    $podcasters = \App\Models\User::where('type', 'podcaster')->get();
    foreach ($podcasters as $podcaster) {
        $sitemap->add(Spatie\Sitemap\Tags\Url::create("/podcasters/{$podcaster->id}"));
    }

    // Add podcaster index page
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/podcasters'));

    // Dynamic: Add category routes
    $categories = \App\Models\Category::all();
    foreach ($categories as $category) {
        $sitemap->add(Spatie\Sitemap\Tags\Url::create("/categories/{$category->id}"));
    }

    // Add category index page
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/categories'));

    // Dynamic: Add article routes
    $articles = \App\Models\Article::all();
    foreach ($articles as $article) {
        $sitemap->add(Spatie\Sitemap\Tags\Url::create("/articles/{$article->id}"));
    }

    // Add article index page
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/articles'));

    // Add static pages from the GeneralController
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/contact-us'));
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/about-us'));
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/privacy-policy'));
    $sitemap->add(Spatie\Sitemap\Tags\Url::create('/terms-conditions'));

    // Save the sitemap
    $sitemap->writeToFile(public_path('sitemap.xml'));

    return "Sitemap generated!";
});
