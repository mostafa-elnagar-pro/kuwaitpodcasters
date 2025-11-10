<x-website.layout>

    <div class="main">
        <div class="barcrumb">
            <h1>{{ __kw('podcasts', 'صانعي المحتوي') }}</h1>
            <div>
                <a href="index.html">{{ __kw('home', 'الرئيسية') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ __kw('podcasts', 'صانعي المحتوي') }}</span>
            </div>
        </div>
        <section class="channels py-5">
            <div class="container">
                <div id="podcasts_container" class="row">
                    <!-- podcasts inserted dynamically by ajax -->
                </div>
            </div>

            @if ($category->podcasts_count === 0)
            <div class="py-5 text-center">
                <img class="w-h-100 m-auto my-4" alt="empty" src="{{ asset('website-assets/images/empty-podcast.png') }}" />
                <p class="text-secondary fs-5">
                    {{ __kw('no_category_podcasts_found', 'لم يتم اضافة حلقات في هذه الفئة حتي الان') }}
                </p>
            </div>
            @endif

            <div id="loading" class="my-3" style="display:none;">
                <div class="loader"></div>
            </div>
        </section>
    </div>

    @push('js')
        <x-scripts.infinite-scroll-loader />

        <script>
            $(document).ready(function() {
                var podcastCount = `{{ $category->podcasts_count }}`;

                if (podcastCount == 0) return;

                var apiUrl = `{{ route('website.podcasts.index') }}`;
                var categoryId = `{{ $category->id }}`;

                var apiUrlWithFilter = `${apiUrl}?filter=category&category_id=${categoryId}`;

                infiniteScrollLoader(apiUrlWithFilter, '#podcasts_container', true);
            });
        </script>
    @endpush

</x-website.layout>
