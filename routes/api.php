<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryPodcastController;
use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\SeasonPodcastController;
use App\Http\Controllers\Api\ChannelSeasonController;
use App\Http\Controllers\Api\FollowUserController;
use App\Http\Controllers\Api\ExclusiveEpisodeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PodcastCommentController;
use App\Http\Controllers\Api\PodcasterController;
use App\Http\Controllers\Api\PodcastViewController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RateAppController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserFavourieController;
use App\Http\Controllers\Api\PodcastController;
use Illuminate\Support\Facades\Route;


Route::middleware('setClientLocale')->group(function () {



    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', RegisterController::class);
        Route::post('login', LoginController::class);

        Route::controller(ResetPasswordController::class)->group(function () {
            Route::post('forgot-password', 'sendOTP');
            Route::post('verify-otp', 'verifyOTP');
            Route::put('password-reset', 'resetPWD');
        });
    });


    Route::get('home', HomeController::class);

    Route::group(['middleware' => ['auth-cookie-checker', 'auth:sanctum']], function () {

        Route::get('podcasters', PodcasterController::class);

        Route::controller(ProfileController::class)->group(function () {
            Route::put('profile', 'update');
            Route::get('profile/{id}', 'show');
        });


        Route::post('users/{user}/follow-toggle', FollowUserController::class);

        Route::scopeBindings()->group(function () {
            Route::apiResource('channels', ChannelController::class);
            Route::apiResource('channels.seasons', ChannelSeasonController::class)->except('show');
            Route::apiResource('channels.seasons.podcasts', SeasonPodcastController::class)->except('show');
        });

        Route::apiResource('books', BookController::class);

        Route::apiResource('exclusive-episodes', ExclusiveEpisodeController::class);

        Route::get('podcasts/{filter}', PodcastController::class);

        Route::resource('podcasts.comments', PodcastCommentController::class)->except('show');

        Route::controller(UserFavourieController::class)->group(function () {
            Route::get('favourites', 'index');
            Route::post('podcasts/{podcast}/like-toggle', 'toggle');
        });

        Route::post('podcasts/{podcast}/view', PodcastViewController::class);

        Route::get('notifications', NotificationController::class);

        Route::get('categories/{category}/podcasts', CategoryPodcastController::class);

        Route::controller(RateAppController::class)->group(function () {
            Route::get('app-rate', 'show');
            Route::post('app-rate', 'store');
            Route::delete('app-rate', 'destroy');
        });

        Route::post('logout', LogoutController::class);
    });



    Route::post('contact', ContactUsController::class);
    Route::get('categories', CategoryController::class);
    Route::get('settings', SettingController::class);
});
