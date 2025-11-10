<x-website.layout>

    <div class="main">
        <div class="barcrumb">
            <h1>{{ __kw('episodes', 'الحلقات') }}</h1>
            <div>
                <a href="index.html">{{ __kw('home', 'الرئيسية ') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ __kw('episodes', 'الحلقات') }}</span>
            </div>
        </div>
        <section class="channels py-5">
            <div class="container">
                <div class="popular-flex">
                    <h2 class="section-title align-items-baseline">{{ __kw('episodes', 'البودكاستات') }}</h2>
                    <div class="position-relative filter-container">
                        <img alt="filter" src="{{ asset('website-assets/images/filter.svg') }}">
                        <select id="podcast_filter" name="filter" class="filterBy">
                            <option value="all" selected="selected">{{ __kw('all', 'الكل') }}</option>
                            <option value="most-viewed">{{ __kw('most_viewed', 'الاكثر استماعا') }}</option>
                            <option value="most-recent">{{ __kw('most_recent', 'الاحدث') }}</option>
                            {{-- <option>{{__kw('fastest','الاسرع')}}</option> --}}
                        </select>
                    </div>
                </div>
                <div id="podcasts_container" class="row py-5  custom-gutters">
                    <!-- podcasts inserted dynamically by ajax -->
                </div>

                <div id="loading" class="my-3" style="display:none;">
                    <div class="loader"></div>
                </div>
            </div>
        </section>
    </div>


    @push('js')
        <x-scripts.infinite-scroll-loader />

        <script>
            $(document).ready(function() {
                var apiUrl = `{{ route('website.podcasts.index') }}`;
                var podcastFilter = $('#podcast_filter').val();
                var apiUrlWithFilter = apiUrl + '?filter=' + podcastFilter;

                infiniteScrollLoader(apiUrlWithFilter, '#podcasts_container', true);

                $('#podcast_filter').on('change', function() {
                    podcastFilter = $(this).val();
                    apiUrlWithFilter = apiUrl + '?filter=' + podcastFilter;

                    $('#podcasts_container').empty();
                    infiniteScrollLoader(apiUrlWithFilter, '#podcasts_container', true);
                });
            });
        </script>
    @endpush

</x-website.layout>
