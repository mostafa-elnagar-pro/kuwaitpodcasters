@props(['id' => 'select2WithOptionIcon'])

<script>
    $(document).ready(function() {
        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }
            const imgSrc = $(option.element).data('img');
            let $option;
            if (imgSrc) {
                $option = $(
                    `<span>${option.text}<img src="${imgSrc}" class="mx-50" style="width:30px;height:30px;border-radius:50%;"></span>`
                );
            } else {
                $option = $(`<span>${option.text}</span>`);
            }
            return $option;
        }

        $('#{{ $id }}').select2({
            templateResult: formatOption,
            templateSelection: formatOption
        });
    });
</script>
