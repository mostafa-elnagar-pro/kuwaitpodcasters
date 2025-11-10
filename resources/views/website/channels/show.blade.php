<x-website.layout>

    <div class="main">
        <div class="barcrumb">
            <h1>{{ $channel->name }}</h1>
            <div>
                <a href="{{ route('website.index') }}">{{ __kw('home', 'الرئيسية') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <a href="{{ route('website.channels.index') }}">
                    {{ __kw('channels', 'القنوات') }}
                </a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ $channel->name }}</span>
            </div>
        </div>
        <div class="container">
            <section class="channal-details">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="image">
                            <img alt="main podcast image" src="{{ displayFile($channel->image) }}">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="info">
                            <div class="d-flex justify-content-between">
                                <h2>{{ $channel->name }}</h2>
                            </div>

                            <div class="numbers">
                                <h5>{{ $channel->podcasts_count }} {{ __kw('podcasts', 'بودكاست') }}</h5>
                                <h4> | </h4>
                                <h5>{{ $channel->seasons_count }} {{ __kw('seasons', 'مواسم') }}</h5>
                            </div>
                            <p>{{ $channel->description }}</p>
                            <div class="owner">
                                <div class="podcaster">
                                    <img alt="podcaster"
                                        src="{{ displayFile($channel->owner->profile_img, 'default-user.svg') }}">
                                    <a
                                        href="{{ route('website.podcasters.show', $channel->owner) }}">{{ $channel->owner->name ?? '' }}</a>
                                </div>
                                <label>{{ $channel->owner->category->name ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            @if ($channel->seasons_count > 0)
                <div>
                    <div class="popular-flex py-3">
                        <h2 class="section-title align-items-baseline">{{ __kw('podcasts', 'الحلقات') }}</h2>
                        <div class="position-relative filter-container">
                            <img alt="filter" src="{{ asset('website-assets/images/filter.svg') }}">
                            <select id="season_filter" class="filterBy">
                                @foreach ($channel->seasons as $season)
                                    <option value="{{ $season->id }}" @selected($loop->first)>
                                        {{ $season->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div id="podcasts_container" class="row custom-gutters">
                    <!-- podcasts inserted dynamically by ajax -->
                </div>

                <div id="loading" class="my-3" style="display:none;">
                    <div class="loader"></div>
                </div>
            @else
                <div class="py-5 text-center">
                    <img class="w-h-100 m-auto my-4" alt="empty" src="{{ asset('website-assets/images/empty.png') }}" />
                    <p class="text-secondary fs-5">{{ __kw('no_seasons_found', 'لم يتم اضافة مواسم حتي الان') }}</p>
                </div>
            @endif
        </div>
    </div>




    @push('js')
        <x-scripts.infinite-scroll-loader />

        <script>
            $(document).ready(function() {
                var apiUrl = `{{ route('website.podcasts.index') }}`;
                var seasonId = $('#season_filter').val();

                var apiUrlWithFilter = `${apiUrl}?filter=season&season_id=${seasonId}`;

                infiniteScrollLoader(apiUrlWithFilter, '#podcasts_container', true);

                $('#season_filter').on('change', function() {
                    var seasonId = $('#season_filter').val();
                    apiUrlWithFilter = `${apiUrl}?filter=season&season_id=${seasonId}`;

                    $('#podcasts_container').empty();
                    infiniteScrollLoader(apiUrlWithFilter, '#podcasts_container', true);
                });
            });
        </script>
    @endpush

</x-website.layout>
