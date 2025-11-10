<x-website.layout :is-header-white="true">

    <div class="main">
        <div class="container" style="margin-top:120px;">
            <div class="col-lg-9 m-auto">
                <video id="player" controls style="width:100%;height:100%;">
                    <source src="{{ $podcast->media_source === 'link' ? $podcast->link : displayFile($podcast->link) }}"
                        type="video/mp4" />
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

        <div class="container py-5">
            <div class="podcast">
                <div class="row">
                    <div class="col-lg-12">
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


        <x-website.podcast-comments :$podcast :$user_comment />

    </div>


    @push('js')
        <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>

        <script>
            const player = new Plyr('#player');
        </script>
    @endpush

    @push('css')
        <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    @endpush

</x-website.layout>
