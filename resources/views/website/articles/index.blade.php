<x-website.layout>
    <div class="main">
        <div class="barcrumb">
            <h1>{{ __kw('articles_news', 'الاخبار و المقالات') }}</h1>
            <div>
                <a href="index.html">{{ __kw('home', 'الرئيسية') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ __kw('articles_news', 'الاخبار و المقالات') }}</span>
            </div>
        </div>
        <section class="articles py-5">
            <div class="container">
                <div id="articles_container" class="row">
                    <!-- articles inserted dynamically by ajax -->
                </div>
            </div>

        
            <div id="loading" class="my-3" style="display:none;">
                <div class="loader"></div>
            </div>

        </section>
    </div>

    @push('js')
        <x-scripts.infinite-scroll-loader />

        <script>
            $(document).ready(function() {
                var apiUrl = `{{ route('website.articles.index') }}`;
                infiniteScrollLoader(apiUrl, '#articles_container');
            });
        </script>
    @endpush
</x-website.layout>
