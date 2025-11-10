@props(['item'])

<div class="mt-2">
    <video id="player_{{ $item->id }}" controls class="w-100">
        <source src="{{ displayFile($item->value) }}" type="video/mp4" />
        Your browser does not support the video tag.
    </video>
</div>

@once
    @push('js')
        <script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
    @endpush

    @push('css')
        <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    @endpush
@endonce

@push('js')
    <script>
        new Plyr('#player_{{ $item->id }}');

        function previewVideo(e, id) {
            const file = e.target.files[0];
            const previewElement = document.getElementById(`player_${id}`);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log(e.target.result)
                    previewElement.src = e.target.result;
                    previewElement.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
