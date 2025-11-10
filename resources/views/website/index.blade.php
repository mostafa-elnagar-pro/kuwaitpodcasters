@php
    $general = app('settings')['general'] ?? [];
    $channel_count = count($channels);
@endphp

<x-website.layout>

    @push('css')
        <style>
            .categories::after {
                background-image: url({{ @$general['categories_pattern'] }});
            }

            .articles::after {
                background-image: url({{ @$general['articles_pattern'] }});
            }

            .reviews::after {
                background-image: url({{ @$general['reviews_pattern'] }});
            }

            .contact-us {
                background-image: url({{ @$general['contact_us_pattern'] }});
            }

            .nav-reviews-slider .slick-slide {
                width: 100% !important;
            }

            .nav-reviews-slider .slick-track {
                transform: translateX(50%) !important;
                width: fit-content !important;
                display: flex !important;
            }
        </style>
    @endpush

    <div class="main">
        <section class="home">
            <div class="home-slider">
                @foreach ($sliders as $slider)
                    <div class="slide">
                        <img alt="slider" src="{{ $slider }}">
                        <div class="container">
                            <div class="content">
                                <!-- <span>بودكاست ديني</span> -->
                                {{-- <h1>{{ __kw('listen', 'Listen') }}</h1>
                                <p>{{ __kw('to_us_daily', 'To Us Daily') }}</p> --}}
                                <button class="google"
                                    onclick="window.open('{{ @$general['google_play_link'] }}', '_blank');">
                                    <i class="fa-brands fa-google-play"></i>
                                    {{ __kw('google', 'Google') }}
                                </button>
                                <button class="apple"
                                    onclick="window.open('{{ @$general['app_store_link'] }}', '_blank');">
                                    <i class="fa-brands fa-apple"></i>
                                    {{ __kw('apple', 'Apple') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- <div class="arrow next">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <div class="arrow prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </div> -->
        </section>
        <div class="container wow fadeInUp" data-wow-delay="0.5s">
            <div class="audio-section">
                <div class="info">
                    <h2>{{ __kw('home_audio_title', 'كيف تبني عادة في 30 يومًا مع ليندا؟') }}</h2>
                    <p>{{ __kw('home_audio_subtitle', 'استمع للبودكاست الرئيسى') }}</p>
                </div>
                <audio preload="auto" controls>
                    <source src="{{ @$general['main_audio_mp3'] }}">
                    <source src="{{ @$general['main_audio_ogg'] }}">
                    <source src="{{ @$general['main_audio_wav'] }}">
                </audio>
            </div>
        </div>

        @if ($channel_count > 0)
            <section class="channels">
                <div class="container">
                    <div class="popular-flex">
                        <h2 class="section-title align-items-baseline">
                            {{ __kw('podcast_channels', 'قنوات البودكاست') }}</h2>
                        <a class="ps-30 fs-5"
                            href="{{ route('website.channels.index') }}">{{ __kw('see_all', 'مشاهدة الكل') }}</a>
                    </div>
                </div>

                @if ($channel_count > 4)
                    <div class="marquee">
                        @foreach ($channels as $channel)
                            <a class="chanal-card" href="{{ route('website.channels.show', $channel->id) }}">
                                <img class="thumbnail" alt="channel" src="{{ displayFile($channel->image) }}">
                                <div class="content">
                                    <span class="info">{{ $channel->name }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="container hidden-mob">
                        <div class="row">
                            @foreach ($channels as $channel)
                                <div class="col-lg-3">
                                    <a class="chanal-card" href="{{ route('website.channels.show', $channel->id) }}">
                                        <img class="thumbnail" alt="channel" src="{{ displayFile($channel->image) }}">
                                        <div class="content">
                                            <span class="info">{{ $channel->name }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>
        @endif

        @if (count($most_viewed_podcasts) > 0)
            <section class="podcastes wow fadeInUp" data-wow-delay="0.4s">
                <div class="container">
                    <div class="popular-flex">
                        <h2 class="section-title align-items-baseline">
                            {{ __kw('most_viewed_podcasts', 'الحلقات الأكثر إستماعا') }}</h2>
                        <a class="ps-30 fs-5" href="{{ route('website.podcasts.index') }}">
                            {{ __kw('see_all', 'مشاهدة الكل') }}
                        </a>
                    </div>
                    <div class="row custom-gutters">
                        @foreach ($most_viewed_podcasts as $podcast)
                            <div class="col-lg-3 col-6">
                                <x-website.podcast-card :$podcast />
                            </div>
                        @endforeach
                    </div>
                    {{-- <div class="arr-container">
                        <div class="arrow next">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="arrow prev">
                            <i class="fa-solid fa-arrow-left"></i>
                        </div>
                    </div> --}}
                </div>
            </section>
        @endif

        <section class="mt-5 start-podcast wow fadeInUp" data-wow-delay="0.4s">
            <video autoplay muted loop>
                <source src="{{ @$general['become_podcaster_video'] }}" type="video/mp4">
            </video>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="start-podcast-content">
                            <img class="logo" alt="logo"
                                src="{{ asset('website-assets/images/logo-white.png') }}" />
                            <h2>{{ __kw('start_your_podcast_today', 'لنبدأ البودكاست الخاص بك اليوم!') }}</h2>
                            <button onclick="window.open('{{ @$general['google_play_link'] }}', '_blank');">
                                {{ __kw('start_podcast_action_text', 'كن بودكاستر') }}</button>
                            <img alt="mic" class="mic" src="{{ asset('website-assets/images/logo.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (count($categories) > 0)
            <section class="categories wow fadeInUp" data-wow-delay="0.4s">
                <div class="container">
                    <div class="popular-flex">
                        <h2 class="section-title align-items-baseline">{{ __kw('categories', 'التصنيفات') }}</h2>
                        <a class="ps-30 fs-5" href="{{ route('website.categories.index') }}">
                            {{ __kw('see_all', 'مشاهدة الكل') }}
                        </a>
                    </div>
                    <div class="category-slider">
                        @foreach ($categories as $category)
                            <a href="{{ route('website.categories.show', $category) }}" class="category">
                                <img alt="cat" src="{{ displayFile($category->image) }}">
                                <h3>{{ $category->name }}</h3>
                            </a>
                        @endforeach
                    </div>
                    <div class="arr-container">
                        <div class="arrow next">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="arrow prev">
                            <i class="fa-solid fa-arrow-left"></i>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if (count($most_recent_podcasts) > 0)
            <section class="news wow fadeInUp" data-wow-delay="0.4s">
                <div class="container">
                    <div class="popular-flex">
                        <h2 class="section-title align-items-baseline">{{ __kw('most_recent', 'الاحدث') }}</h2>
                        <a class="ps-30 fs-5" href="{{ route('website.podcasts.index') }}">
                            {{ __kw('see_all', 'مشاهدة الكل') }}
                        </a>
                    </div>
                    <div class="row custom-gutters">
                        @foreach ($most_recent_podcasts as $podcast)
                            <div class="col-lg-3 col-6">
                                <x-website.podcast-card :$podcast />
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if (count($featured_podcasters) > 0)
            <section class="podcasters wow fadeInUp" data-wow-delay="0.4s">
                <div class="container">
                    <div class="popular-flex">
                        <h2 class="section-title align-items-baseline">
                            {{ __kw('podcasters', 'صانعي المحتوي') }}
                        </h2>
                        <a class="ps-30 fs-5"
                            href="{{ route('website.podcasters.index') }}">{{ __kw('see_all', 'مشاهدة الكل') }}</a>
                    </div>
                    <div class="podcasters-slider">
                        @foreach ($featured_podcasters as $podcaster)
                            <div>
                                <a href="{{ route('website.podcasters.show', $podcaster) }}" class="podqaster">
                                    <img class="profile-img" alt="podqaster"
                                        src="{{ displayFile($podcaster->profile_img, 'default-user.svg') }}">
                                    <h3>{{ $podcaster->name }}</h3>
                                    <!-- <span>مدير فني</span> -->
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="arr-container">
                        <div class="arrow next">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="arrow prev">
                            <i class="fa-solid fa-arrow-left"></i>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="download-app wow fadeInUp" data-wow-delay="0.4s">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 class="section-title align-items-baseline">
                            {{ __kw('download_app_now', 'قم بتنزيل التطبيق الان') }}</h2>
                        <p>{!! __kw(
                            'download_short_about',
                            'بودكاستي هي المنصة الرائدة في تقديم المحتوى العربي حصرياً لمستمعيها <br> من خلال الموقع الالكتروني و تطبيق الهاتف الذكي.',
                        ) !!}</p>
                        <div class="stores">
                            <a href="{{ @$general['google_play_link'] }}" target="blank">
                                <img alt="google"
                                    src="{{ asset('website-assets/images/google-play-badge.webp') }}">
                            </a>
                            <a href="{{ @$general['app_store_link'] }}" target="blank">
                                <img alt="apple" src="{{ asset('website-assets/images/app-store.webp') }}">
                            </a>
                        </div>
                    </div>
                    @isset($general['download_section_mockup'])
                        <div class="col-lg-6">
                            <img alt="mockup" class="mockup" src="{{ $general['download_section_mockup'] }}">
                        </div>
                    @endisset
                </div>
            </div>
        </section>

        @if (count($app_reviews) > 0)
            <section class="reviews wow fadeInUp" data-wow-delay="0.4s">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="reviews-content">
                                <h5>{{ __kw('our_reviews', 'شهاداتنا') }} </h5>
                                <h2>{{ __kw('users_comments', 'تعليقات من المستخدمين') }}</h2>
                                <div class="d-flex">
                                    <div class="w-100 nav-reviews-slider">
                                        @foreach ($app_reviews->pluck('user.profile_img') as $image)
                                            <div style="width:fit-content">
                                                <img class="reviewer" alt="reviewer"
                                                    src="{{ displayFile($image, 'default-user.svg') }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if (count($app_reviews) > 1)
                                        <div class="arrows">
                                            <div class="arrow next">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </div>
                                            <div class="arrow prev">
                                                <i class="fa-solid fa-arrow-left"></i>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="reviews-slider">
                                    @foreach ($app_reviews as $review)
                                        <div class="review">
                                            <img class="reviewer" alt="reviewer"
                                                src="{{ displayFile($review->user->profile_img, 'default-user.svg') }}">
                                            <div class="content">
                                                <p>{{ $review->message }}</p>
                                                <div class="abour-reviewer">
                                                    <div>
                                                        <div class="rating">
                                                            @foreach (range(1, $review->value) as $val)
                                                                <i class="fa-solid fa-star"></i>
                                                            @endforeach
                                                        </div>
                                                        <h6>{{ $review->user->name }}</h6>
                                                        <span>{{ $review->user->type }}</span>
                                                    </div>
                                                    <i class="fa-solid fa-quote-left quotes"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        @isset($general['review_section_image'])
                            <div class="col-lg-5">
                                <img alt="testimonial-img" class="testimonial-img"
                                    src="{{ $general['review_section_image'] }}">
                            </div>
                        @endisset
                    </div>
                </div>
            </section>
        @endif

        @if (count($articles) > 0)
            <section class="articles wow fadeInUp">
                <div class="container">
                    <div class="popular-flex">
                        <h2 class="section-title align-items-baseline">
                            {{ __kw('articles_news', 'اخبار ومقالات') }}
                        </h2>
                        <a class="ps-30 fs-5" style="z-index:100" href="{{ route('website.articles.index') }}">
                            {{ __kw('see_all') }}
                        </a>
                    </div>
                    <div class="row pt-5">
                        @foreach ($articles as $article)
                            <div class="col-lg-4" style="position: relative">
                                <div class="article">
                                    <div class="img-container">
                                        <img alt="article img" src="{{ displayFile($article->image) }}">
                                    </div>
                                    <div class="content">
                                        <span>
                                            <i class="fa fa-calendar-week"></i>
                                            {{ $article->created_at->diffForHumans() }}
                                        </span>
                                        <h5>{{ $article->title }}</h5>
                                        <div class="desc">
                                            <p>{{ $article->short_body }}</p>
                                        </div>
                                        <a href="{{ route('website.articles.show', $article) }}">
                                            {{ __kw('show_more', 'عرض المزيد') }}
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif



        <x-website.contact-us-card :$general />
    </div>


    @push('css')
        <link rel="stylesheet" href="https://tympanus.net/Development/AudioPlayer/css/audioplayer.css" />
    @endpush


    @push('js')
        <script src="https://tympanus.net/Development/AudioPlayer/js/audioplayer.js"></script>
        <script>
            $(function() {
                $('audio').audioPlayer();
            });
        </script>
    @endpush

</x-website.layout>
