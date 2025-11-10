@props(['item'])

<audio id="player_{{ $item->id }}" controls class="w-100 mt-1">
    <source src="{{ displayFile($item->value) }}" />
</audio>


@once
    @push('js')
        <script src="{{ asset('website-assets/js/player.js') }}"></script>
    @endpush
    @push('css')
        @vite(['resources/scss/media.scss', 'resources/scss/style.scss'])
    @endpush
@endonce


@push('js')
    <script>
        function previewAudio(e, id) {
            const file = e.target.files[0];
            const previewElement = document.getElementById(`player_${id}`);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewElement.src = e.target.result;
                    previewElement.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
