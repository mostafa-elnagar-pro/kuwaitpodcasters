<x-website.layout>
    <div class="main">
        <div class="barcrumb">
            <h1>{{ __kw('podcasters', 'صانعي المحتوي') }}</h1>
            <div>
                <a href="index.html">{{ __kw('home', 'الرئيسية') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <a href="podcasters.html">{{ __kw('podcasters', 'صانعي المحتوي') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ $podcaster->name }}</span>
            </div>
        </div>
        <div class="container">
            <div class="podqaster-page row">
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="podqaster-image">
                        <img alt="podqaster" src="{{ displayFile($podcaster->profile_img, 'default-user.svg') }}">
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="podqaster-info">
                        <p class="job">{{ $podcaster->category->name }}</p>
                        <h2 class="name">{{ $podcaster->name }}</h2>
                        <p class="breif">
                            {{ $podcaster->podcasterDetails->bio }}
                        </p>
                        <span id="follow_count" class="seasons">
                            @if ($podcaster->followers_count > 0)
                                {{ $podcaster->followers_count . ' ' . __kw('followers', 'متابع') }}
                            @endif
                        </span>
                        <div class="socials">
                            <button id="follow_btn" class="my-btn">
                                {{ $podcaster->is_following ? __kw('unfollow', 'الغاء المتابعة') : __kw('follow', 'متابعة') }}
                            </button>

                            @if (isset($podcaster->podcasterDetails))
                                @foreach (['facebook', 'twitter', 'instagram', 'youtube', 'snapchat', 'tiktok', 'linkedin'] as $platform)
                                    @if ($podcaster->podcasterDetails->$platform)
                                        <a href="{{ $podcaster->podcasterDetails->$platform }}" target="_blank">
                                            <i class="fab fa-{{ $platform }}"></i>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>


                    </div>
                </div>
            </div>
            @if ($podcaster->channel && $podcaster->channel->seasons_count > 0)
                <div class="py-5 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="popular-flex">
                        <h2 class="section-title align-items-baseline">{{ __kw('my_podcasts', 'بودكاستاتى') }}</h2>
                        <div class="position-relative filter-container">
                            <img alt="filter" src="{{ asset('website-assets/images/filter.svg') }}">
                            <select id="season_filter" class="filterBy">
                                @foreach ($podcaster->channel->seasons as $season)
                                    <option value="{{ $season->id }}" @selected($loop->first)>
                                        {{ $season->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="podcasts_container" class="row py-5">
                        <!-- podcasts inserted dynamically by ajax -->
                    </div>

                    <div id="loading" class="my-3" style="display:none;">
                        <div class="loader"></div>
                    </div>

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

                $('#follow_btn').on('click', function() {
                    const button = $(this);
                    const podcasterId = button.data('podcaster-id');
                    const authToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: `{{ route('website.podcaster.follow', $podcaster) }}`,
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + authToken,
                            'X-CSRF-TOKEN': authToken
                        },
                        success: function(response) {
                            button.text(response?.button_text)
                            $('#follow_count').text(response?.follow_count)
                        },
                    });
                });
            });
        </script>
    @endpush
</x-website.layout>
