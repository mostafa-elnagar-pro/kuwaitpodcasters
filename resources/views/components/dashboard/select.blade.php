@props(['name'])


<select id="{{ $name }}" name="{{ $name }}" class="form-select select2">
    {{ $slot }}
</select>


@push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                minimumResultsForSearch: Infinity // Disable the search box
            });
        });
    </script>
@endpush
