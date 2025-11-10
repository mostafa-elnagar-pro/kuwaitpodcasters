<x-website.layout>

    <div class="main">
        <div class="barcrumb">
            <h1>{{ $podcast->name }}</h1>
            <div>
                <a href="{{ route('website.index') }}">
                    {{ __kw('home', 'الرئيسية') }}
                </a>
                <i class="fa-solid fa-chevron-left"></i>
                <a href="{{ route('website.podcasts.index') }}">
                    {{ __kw('episodes', 'الحلقات') }}
                </a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ $podcast->name }}</span>
            </div>
        </div>

        <div class="container py-5">
            <div class="podcast">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="video-player">
                            <audio id="myVideo">
                                <source
                                    src="{{ $podcast->media_source === 'link' ? $podcast->link : displayFile($podcast->link) }}">
                            </audio>
                            <img alt="image" src="{{ displayFile($podcast->image) }}">
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="controls p-4">
                            <div class="w-100 controls-container">
                                <button id="playPauseBtn"><i class="fa-solid fa-play"></i></button>
                                <input id="seekBar" type="range" min="0" max="100" value="0">
                                <span id="currentTime">0:00</span> / <span id="duration">0:00</span>
                                <button id="muteBtn"><i class="fa-solid fa-volume-high"></i></button>
                                <input id="volumeBar" type="range" min="0" max="1" step="0.1"
                                    value="1">
                                <!-- <button id="fullScreenBtn">
                                    <i class="fa-solid fa-expand"></i>
                                </button> -->
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="details">
                                <div class="popular-flex">
                                    <div class="d-flex">
                                        <p>{{ $podcast->season->name }}</p>
                                        <p class="mx-3">|</p>
                                        <a href="{{ route('website.podcasters.show', $podcast->podcaster) }}">
                                            {{ $podcast->podcaster->name }}
                                        </a>
                                    </div>
                                    <div class="info">
                                        @if ($podcast->views_count > 0)
                                            <label>
                                                <span>{{ $podcast->views_count }}</span>
                                                <i class="fa-solid fa-headphones"></i>
                                            </label>
                                        @endif

                                        @include('website.includes.podcast-like', [
                                            'podcast' => $podcast,
                                        ])
                                    </div>
                                </div>
                                <h1>{{ $podcast->name }}</h1>
                                <div class="description">
                                    {{ $podcast->description }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <x-website.podcast-comments :$podcast :$user_comment />
    </div>



    @push('js')
        <script src="{{ asset('website-assets/js/player.js') }}"></script>
    @endpush
</x-website.layout>
