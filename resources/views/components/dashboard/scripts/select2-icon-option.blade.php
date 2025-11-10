<Script>
    $(document).ready(function() {
        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }
            var $option = $(
                `<span><span class="flag-icon ${$(option.element).data('icon')}"></span>${option.text}</span>`
            );
            return $option;
        }

        $('#select2WithOptionIcon').select2({
            templateResult: formatOption,
            templateSelection: formatOption
        });
    });
</Script>
