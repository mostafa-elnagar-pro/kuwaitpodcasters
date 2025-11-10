<x-website.layout>
    <div class="main">
        <div class="barcrumb">
            <h1>{{ __kw('categories', 'صانعي المحتوي') }}</h1>
            <div>
                <a href="index.html">{{ __kw('home', 'الرئيسية') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ __kw('categories', 'صانعي المحتوي') }}</span>
            </div>
        </div>
        <section class="channels py-5">
            <div class="container">
                <div id="categories_container" class="row">
                    <!-- categories inserted dynamically by ajax -->
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
                var apiUrl = `{{ route('website.categories.index') }}`;
                infiniteScrollLoader(apiUrl, '#categories_container');
            });
        </script>
    @endpush
</x-website.layout>
