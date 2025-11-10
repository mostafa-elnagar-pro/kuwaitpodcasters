@foreach ($podcasts as $podcast)
    <div class="col-lg-3 col-6">
        <x-website.podcast-card :$podcast />
    </div>
@endforeach

@once
    @if (count($podcasts) === 0)
        <div id="not_found_el" class="py-5 text-center">
            <img class="w-h-100 m-auto my-4" alt="empty" src="{{ asset('website-assets/images/empty.png') }}" />
            <p class="text-secondary fs-5">
                @if ($is_search)
                    {{ __kw('no_results_found', 'لا توجد نتائج') }}
                @else
                    {{ __kw('no_podcasts_found', 'لا توجد حلقات') }}
                @endif
            </p>
        </div>
    @endif
@endonce
