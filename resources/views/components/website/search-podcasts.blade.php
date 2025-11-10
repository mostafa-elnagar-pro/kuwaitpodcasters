<div class="search-container flex-column d-none">
    <div class="backdrop"></div>
    <div class="col-12 col-md-8 col-lg-6 gap-50 search-form">
        <input type="text" id="search_input" placeholder="{{ __kw('search', 'بحث') }}" class="flex-grow-1" />
        <button id="search_btn"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>

    <div class="results-container col-12 col-md-8 col-lg-6">
        <ul id="search_results" class="d-flex flex-column gap-2">
            <!-- search results inserted dynamically -->
        </ul>

        <h6 id="no_results_el" class="py-4 text-secondary text-center">{{ __kw('no_results_found', 'لا توجد نتائج') }}</h6>
    </div>
</div>



@push('js')
    <script>
        $(document).ready(function() {
            const debounce = (func, delay) => {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(null, args), delay);
                };
            };

            const fetchResults = () => {
                const searchText = $('#search_input').val().trim();
                if (!searchText) {
                    $('#search_results').empty().hide();
                    $('#no_results_el').show();
                    return;
                }

                $.ajax({
                    url: "{{ route('website.podcasts.search') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        search: searchText
                    },
                    success: response => {
                        if (response?.status) displayResults(response.podcasts);
                    },
                    error: xhr => console.log("Error:", xhr.responseText)
                });
            };

            const displayResults = (results) => {
                $('#search_results').empty();
                if (results.length > 0) {
                    $('#no_results_el').hide();
                    $('#search_results').show();
                    results.forEach(result => {
                        const podcastUrl = `{{ route('website.podcasts.show', ['podcast' => 'ID']) }}`
                            .replace('ID', result.id);
                        $('#search_results').append(
                            `<li class='search-item'><a href='${podcastUrl}'>${result.name}</a></li>`
                        );
                    });
                } else {
                    $('#search_results').hide();
                    $('#no_results_el').show();
                }
            };

            const visitSearchResults = () => {
                const pageUrl = `{{ route('website.podcasts.search.index', ['search' => 'SEARCH']) }}`
                    .replace('SEARCH', $('#search_input').val());
                window.location.href = pageUrl;
            };

            $('#search_input').on('input', debounce(fetchResults, 300));
            $('#search_input').on('keypress', event => {
                if (event.key === 'Enter') visitSearchResults();
            });
            $('#search_btn').on('click', visitSearchResults);
        });
    </script>
@endpush



<style>
     .results-container {
        background: #fff;
        max-height: 300px;
        overflow-y: auto;
        z-index: 100;
        border-radius: 0 0 10px 10px;
    }
    
    .search-item {
        font-size: 17px;
        font-weight: 400;
        padding: 20px;
        cursor: pointer;
    }

    .search-item:hover {
        background: #eee;
    }
</style>
