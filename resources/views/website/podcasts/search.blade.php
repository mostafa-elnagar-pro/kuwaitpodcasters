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
                </div>
                <div id="podcasts_container" class="row py-5 custom-gutters">
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
                const urlParams = new URLSearchParams(window.location.search);

                var apiUrl = `{{ route('website.podcasts.index') }}`;
                var apiUrlWithFilter = `${apiUrl}?filter=search&search=${urlParams.get('search')}`

                infiniteScrollLoader(apiUrlWithFilter, '#podcasts_container', true);
            });
        </script>
    @endpush

</x-website.layout>
