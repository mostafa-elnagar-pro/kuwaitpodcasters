<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\Auth\LoginController;
use App\Http\Controllers\Website\Auth\RegisterController;
use App\Http\Controllers\Website\ProfileController;
use App\Http\Controllers\Website\ChannelController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\PodcastController;
use App\Http\Controllers\Website\UserController;
use App\Http\Controllers\Website\PodcasterController;
use App\Http\Controllers\Website\PodcastSearchController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\ArticleController;
use App\Http\Controllers\Website\GeneralController;
use App\Http\Controllers\Website\NotificationController;
use App\Http\Controllers\Website\Auth\ResetPasswordController;
use App\Http\Controllers\Website\PodcastCommentController;

Route::group(
    ['as' => 'website.'],
    function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');

        Route::resource('channels', ChannelController::class)->only('index', 'show');

        Route::get('podcasts/search', [PodcastSearchController::class, 'index'])->name('podcasts.search.index');
        Route::post('podcasts/search', [PodcastSearchController::class, 'search'])->name('podcasts.search');
        Route::post('podcasts/{podcast}/like-toggle', [PodcastController::class, 'toggleLike'])->name('podcast.toggleLike');
        Route::resource('podcasts', PodcastController::class)->only('index', 'show');

        Route::resource('users', UserController::class)->only('index', 'show');

        Route::post('podcasters/{podcaster}/follow-toggle', [PodcasterController::class, 'toggleFollow'])->name('podcaster.follow');
        Route::resource('podcasters', PodcasterController::class)->only('index', 'show');

        Route::resource('categories', CategoryController::class)->only('index', 'show');

        Route::resource('articles', ArticleController::class)->only('index', 'show');

        Route::controller(GeneralController::class)->group(function () {
            Route::get('contact-us', 'contact')->name('contact');
            Route::get('about-us', 'about')->name('about');
            Route::get('privacy-policy', 'privacy')->name('privacy');
            Route::get('terms-conditions', 'terms')->name('terms');
        });



        Route::middleware('auth:web')->group(function () {
            Route::controller(ProfileController::class)->group(function () {
                Route::get('profile/{user}', 'show')->name('profile.show');
                Route::put('profile', 'update')->name('profile.update');
            });

            Route::apiResource('podcasts.comments', PodcastCommentController::class);


            Route::put('notifications/{id}/read', NotificationController::class);

            /********* logout route **************/
            Route::post('logout', function () {
                auth()->guard('web')->logout();
                return to_route('website.showLoginForm');
            })->name('logout');
        });

        Route::middleware('guest:web')->group(function () {
            Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
            Route::post('login', [LoginController::class, 'login'])->name('login');

            Route::get('register/user', [RegisterController::class, 'showRegisterForm'])->name('showRegisterForm');
            Route::post('register', [RegisterController::class, 'register'])->name('register');

            Route::get('forgot-password', [ResetPasswordController::class, 'showForgotPasswordForm'])->name('forgot-pwd');
            Route::post('sent-otp', [ResetPasswordController::class, 'sendOTP'])->name('send-otp');
            Route::get('reset-password', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset-pwd.form');
            Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset-pwd');
        });

    }
);



##########################


Route::get('add_extra_keywords', function () {
    $keywords = [
        'sort_by' => ['ar' => 'ترتيب حسب'],
        'comments' => ['ar' => 'التعليقات'],
        'latest' => ['ar' => 'الأحدث'],
        'oldest' => ['ar' => 'الأقدم'],
        'edit' => ['ar' => 'تعديل'],
        'delete' => ['ar' => 'حذف'],
        'write_comment' => ['ar' => 'اكتب تعليقك هنا'],
        'add_comment' => ['ar' => 'اضافة تعليق'],
        'cancel' => ['ar' => 'الغاء'],
        'load_more' => ['ar' => 'عرض المزيد'],
    ];


    foreach ($keywords as $key => $keyword) {
        \App\Models\Keyword::create([
            'key' => $key,
            'value' => $keyword,
            'type' => 'web'
        ]);
    }

    dd("done");

});

Route::get('add_extra_settings', function () {
    \App\Models\Setting::insertOrIgnore([
        [
            'type' => 'text',
            'key' => 'linkedin_link',
            'value' => '',
            'note' => null
        ],
    ]);

    forgetCachedSettings();

    dd("done");

});



/*
 * encode font into base64 for datatable pdf export problem with arabic font
 * add the font folder in public and add path of the folder 
 * then it will automatically give a vfs_fonts.js file in public dir
 */
// Route::get('make_font', function () {
//     $output = "this.pdfMake = this.pdfMake || {}; this.pdfMake.vfs = {";

//     // Get the files in the current directory
//     $files = Illuminate\Support\Facades\File::files(public_path('bahij'));

//     foreach ($files as $file) {
//         $fileName = $file->getFilename();
//         if ($fileName != 'makefont.php' && $fileName != 'vfs_fonts.js') {
//             $output .= '"';
//             $output .= $fileName;
//             $output .= '":"';
//             $output .= base64_encode(Illuminate\Support\Facades\File::get($file->getPathname()));
//             $output .= '",';
//         }
//     }

//     $output = rtrim($output, ',');
//     $output .= "}";

//     // Write the output to vfs_fonts.js
//     $filePath = public_path('vfs_fonts.js');
//     Illuminate\Support\Facades\File::put($filePath, $output);

//     return Illuminate\Support\Facades\Response::json([
//         'message' => 'vfs_fonts.js created', 'file' => $filePath
//     ]);
// });