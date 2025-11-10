<script>
    const debounce = (func, delay) => {
        let timer;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(null, args), delay);
        };
    };

    function infiniteScrollLoader(apiUrl, containerSelector, hasFilter = false) {
        var page = 1;
        var totalPages = null;
        var loading = false;

        loadContent(apiUrl, page);

        $(window).off('scroll').on('scroll', function() { 
            if (($(window).scrollTop() + $(window).height()) >= $(document).height() - 100) {
                if (!loading && (totalPages === null || page < totalPages)) {
                    loading = true;
                    page++;

                    $('#loading').show();

                    debounce(() => loadContent(apiUrl, page), 500)();
                }
            }
        });

        function loadContent(apiUrl, page) {
            var url = hasFilter ? `${apiUrl}&page=${page}` : `${apiUrl}?page=${page}`;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $(containerSelector).append(response.html);
                    totalPages = response.last_page;
                    $('#loading').hide();
                    loading = false;
                },
                error: function(xhr, status, error) {
                    $('#loading').hide();
                    loading = false;
                }
            });
        }
    }
</script>
