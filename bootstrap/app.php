<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/dashboard.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();

        $middleware->redirectUsersTo(function(){
            if (request()->is('*dashboard*')) {
                return route('admin.home');
            }
            else{
                return route('website.index');
            }
        });

        $middleware->redirectGuestsTo(function () {
            if (request()->is('*dashboard*')) {
                return route('admin.login.show');
            } elseif (request()->is('*api*')) {
                return route('website.login');
            }else{
                return route('website.login');
            }
        });

        $middleware->priority([
            \App\Http\Middleware\HttpCookieHandler::class
        ]);

        $middleware->alias([
            // api auth by http cookie
            'auth-cookie-checker' => \App\Http\Middleware\HttpCookieHandler::class,
            'setClientLocale' => \App\Http\Middleware\SetClientLocale::class,

            'isSuperAdmin' => \App\Http\Middleware\CheckIfSuperAdmin::class,
            'isSuperAdminRole' => \App\Http\Middleware\CheckIfSuperAdminRole::class,

            /**** OTHER MIDDLEWARE ALIASES ****/
            'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,


        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return errorResponse(
                    __('messages.unauthenticated'),
                    Response::HTTP_UNAUTHORIZED
                );
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return errorResponse(
                    __('messages.notFound'),
                    Response::HTTP_NOT_FOUND
                );
            }
        });

    })->create();
