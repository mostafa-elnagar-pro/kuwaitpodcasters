<div class="form-check form-switch d-flex flex-column gap-50 align-items-center">
    @if ($podcaster->status === 'pending')
        <span id="pending_text" class="badge bg-warning">{{ __('label.pending') }}</span>
    @endif
    <input id="status_toggler_{{ $podcaster->id }}" type="checkbox" class="form-check-input status-toggle"
        @checked($podcaster->status === 'active') role="switch">
</div>

<script>
    $(document).ready(function() {
        $('#status_toggler_{{ $podcaster->id }}').on('change', function() {
            const isChecked = $(this).prop('checked');
            const $toggle = $(this);

            $.ajax({
                url: "{{ route('admin.podcasters.updateStatus', $podcaster) }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    _method: 'PUT',
                    is_active: isChecked ? 1 : 0,
                },
                success: function(response) {
                    $("#pending_text").remove();
                    toastr.success('Status updated successfully');
                },
                error: function(xhr) {
                    toastr.error('Error updating status');
                    // Revert the toggle if there's an error
                    $toggle.prop('checked', !isChecked);
                }
            });
        });
    });
</script>
