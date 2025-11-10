@props(['isHeaderWhite' => false])

@php
    $settings = app('settings');
    $general = $settings['general'] ?? [];
    $activeLangs = $settings['active_langs'] ?? [];
    $social_links = [
        'facebook' => 'facebook-f',
        'linkedin' => 'linkedin',
        'twitter' => 'x-twitter',
        'instagram' => 'instagram',
        'youtube' => 'youtube',
        'snapchat' => 'snapchat',
        'tiktok' => 'tiktok',
    ];
@endphp

<!DOCTYPE html>
<html>

<head>
    <!-- Meta Tags
        ========================== -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="{{ __kw('meta_title', '') }}">
    <meta name="description" content="{{ __kw('meta_description', '') }}">
    <meta name="keywords" content="podcasters podcast video audio channels seasons">
    <meta name="author" content="elsheikh">
    <meta name="contact" content="mohammed.elsheikh383@gmail.com">
    <meta name="contactNetworkAddress" CONTENT="mohammed.elsheikh383@gmail.com">
    <meta name="contactPhoneNumber" CONTENT="01093867512">
    <!-- Site Title
        ========================== -->
    <title>{{ $title ?? 'Podcasters' }}</title>

    <!-- Favicon
  ===========================-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('website-assets/images/fav.ico') }}">

    <!-- Base & Vendors
        ========================== -->
    <link rel="stylesheet" href="{{ asset('website-assets/vendor/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"
        integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous"> --}}
    <!-- owlcarosel-->
    <link rel="stylesheet" href="{{ asset('website-assets/vendor/slick-1.8.1/slick/slick.css') }}">

    <!-- Site fonts
        ========================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400..800&display=swap" rel="stylesheet">
    <!-- Site Style
        ========================== -->

    <link rel="stylesheet" href="{{ asset('website-assets/vendor/wow/animate.css') }}">

    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    @stack('css')

    @vite(['resources/scss/media.scss', 'resources/scss/style.scss'])

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <style>
        figure>img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body dir="{{ request('lang') === 'en' ? 'ltr' : 'rtl' }}">
    <div class="preloader">
        <span class="loader">
            <img alt="logo" src="{{ asset('website-assets/images/logo.png') }}">
        </span>
    </div>
    <header class="{{ $isHeaderWhite ? 'white-header' : '' }}">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg">

                <x-website.search-podcasts />
                <div class="auth mx-2">
                    {{-- <select id="language_select" class="mx-2" style="cursor:pointer;">
                        @foreach ($activeLangs as $lang)
                            <option value="{{ $lang->abbr }}">{{ $lang->name }}</option>
                        @endforeach
                    </select> --}}

                    @auth
                        <div class="dropdown">
                            <button class="btn notification-btn" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-bs-haspopup="true" aria-bs-expanded="false">
                                <i class="fa-regular fa-bell"></i>
                                @if ($count = auth()->user()->unreadNotifications->count())
                                    <p>{{ $count }}</p>
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-bs-labelledby="dropdownMenuButton">
                                <h6>{{ __kw('notifications', 'الإشعارات') }}</h6>
                                <div class="notifications-container">
                                    @forelse(auth()->user()->notifications()->latest('id')->get() as $notification)
                                        <a class="dropdown-item notification {{ is_null($notification->read_at) ? 'unread' : '' }}"
                                            href="javascript:void(0)"
                                            onclick="handleNotificationClick('{{ $notification->id }}')">
                                            <div>
                                                <img alt="image" src="{{ displayFile($notification->data['image']) }}">
                                                <span>{{ $notification->data['body'] }}</span>
                                            </div>
                                            <span class="time">{{ $notification->created_at->diffForHumans() }}</span>
                                        </a>
                                    @empty
                                        <div class="dropdown-item empty-state" onclick="event.stopPropagation()">
                                            {{ __kw('no_notifications', 'لا توجد إشعارات') }}
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endauth

                    <div class="search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    @auth
                        <a href="{{ route('website.profile.show', auth()->id()) }}" class="user-profile">
                            <img alt="profile" src="{{ displayFile(auth()->user()->profile_img, 'default-user.svg') }}" />
                        </a>
                    @else
                        <a class="login" href="{{ route('website.showLoginForm') }}">{{ __('label.login') }}</a>
                    @endauth
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item {{ request()->routeIs('website.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('website.index') }}">
                                {{ __kw('home', 'الرئيسية') }}
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('website.channels.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('website.channels.index') }}">
                                {{ __kw('channels', 'القنوات') }}
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('website.categories.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('website.categories.index') }}">
                                {{ __kw('categories', 'التصنيفات') }}
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('website.podcasters.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('website.podcasters.index') }}">
                                {{ __kw('podcasters', 'صانعو المحتوى') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('website.about') }}">
                                {{ __kw('about_us', 'من نحن') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('website.contact') }}">
                                {{ __kw('contact_us', 'تواصل معنا') }}
                            </a>
                        </li>
                    </ul>
                    <a class="navbar-brand" href="{{ route('website.index') }}">
                        <img class="dark m-auto" alt="logo" src="{{ asset('website-assets/images/logo.png') }}">
                        <img class="white m-auto" alt="logo"
                            src="{{ asset('website-assets/images/logo-white.png') }}">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
            </nav>
        </div>
    </header>


    {{ $slot }}


    <footer>
        <div class="float-btns">
            <a href="tel:{{ @$general['website_phone'] }}" class="phone animate__animated animate__shakeX"><i
                    class="fa fa-phone"></i></a>
            <a href="{{ @$general['whatsapp_link'] }}" target="_blank"
                class="whats animate__animated animate__shakeX"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4 footer-main">
                    <img alt="logo" src="{{ asset('website-assets/images/logo-white.png') }}">
                    <p>
                        {{ __kw(
                            'footer_short_about',
                            'منصة بودكاستي تقدم لكم عدد كبير و متنوع من البرامج التي من شأنها الارتقاء بمستوى الوعي والمعرفة من خلال تسليط الضوء على العديد من التحديات التي تواجه عالمنا اليوم، حيث يقوم بتقديم هذه البرامج نخبة من المذيعين المتألقين و الموهوبين.',
                        ) }}
                    </p>
                </div>
                <div class="col-md-4 col-lg-4">
                    <h2 class="footer-heading">{{ __kw('short_links', 'روابط سريعة') }}</h2>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <ul>
                                <li>
                                    <a href="{{ route('website.index') }}">
                                        {{ __kw('home', 'الرئيسية') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.channels.index') }}">
                                        {{ __kw('channels', 'القنوات') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.categories.index') }}">
                                        {{ __kw('categories', 'التصنيفات') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.podcasters.index') }}">
                                        {{ __kw('podcasters', 'صانعو المحتوى') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul>
                                <li>
                                    <a href="{{ route('website.about') }}">
                                        {{ __kw('about_us', 'من نحن') }}

                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.contact') }}">
                                        {{ __kw('contact_us', 'تواصل معنا') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.privacy') }}">
                                        {{ __kw('privacy_policy', 'سياسة الخصوصية') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('website.terms') }}">
                                        {{ __kw('terms_conditions', 'الشروط والاحكام') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div>
                        <h2 class="footer-heading">{{ __kw('contact_us', 'تواصل معنا') }}</h2>
                        <hr>
                        <div class="social-buttons">
                            @foreach ($social_links as $key => $icon)
                                @isset($general["{$key}_link"])
                                    <a href="{{ $general["{$key}_link"] }}" target="blank">
                                        <i class="fab fa-{{ $icon }}"></i>
                                    </a>
                                @endisset
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--Script files
            ========================== -->
    <script src="{{ asset('website-assets/vendor/jquery/jquery-min.js') }}"></script>
    {{-- <script src="{{ asset('website-assets/vendor/bootstrap/js/bootstrap.js') }}"></script> --}}
    <script src="{{ asset('website-assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('website-assets/vendor/slick-1.8.1/slick/slick.js') }}"></script>
    <script src="{{ asset('website-assets/vendor/marquee/marquee.js') }}"></script>
    <script src="{{ asset('website-assets/js/main.js') }}"></script>
    <script src="{{ asset('website-assets/vendor/wow/wow.min.js') }}"></script>
    <script>
        new WOW().init();
    </script>
    <script>
        $(function() {
            $(".marquee").marquee({
                //duration in milliseconds of the marquee
                duration: 15000,
                //gap in pixels between the tickers
                gap: 0,
                //time in milliseconds before the marquee will start animating
                delayBeforeStart: 0,
                //'left' or 'right'
                direction: "right",
                //true or false - should the marquee be duplicated to show an effect of continues flow
                duplicated: true,
                pauseOnHover: true
            });
        });

        function handleNotificationClick(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const notificationMap = {
                        'new_channel': {
                            label: 'channels',
                            id: data.data?.channel_id
                        },
                        'new_season': {
                            label: 'seasons',
                            id: data.data?.channel_id
                        },
                        'new_podcast': {
                            label: 'podcasts',
                            id: data.data?.podcast_id
                        },
                    };

                    const type = data.data?.type;

                    if (notificationMap[type]) {
                        location.href = `/${notificationMap[type]['label']}/${notificationMap[type]['id']}`;
                    }

                })
                .catch(error => {
                    // console.error('Error:', error);
                });
        }
    </script>

    @stack('js')
</body>

</html>
