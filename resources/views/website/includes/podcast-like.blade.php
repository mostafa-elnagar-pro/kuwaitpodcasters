<button class="like-toggle-btn" data-podcast-id="{{ $podcast->id }}">
    <span>{{ $podcast->likes_count }}</span>
    <i class="fa fa-heart {{ $podcast->in_favourites ? 'text-danger' : '' }}"></i>
</button>



@push('js')
    <script>
        $(document).ready(function() {
            $('.like-toggle-btn').on('click', function() {
                var button = $(this);
                var authToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `{{ route('website.podcast.toggleLike', $podcast->id) }}`,
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + authToken,
                        'X-CSRF-TOKEN': authToken
                    },
                    success: function(response) {
                        button.html(response);
                    },
                });
            });
        });
    </script>
@endpush
