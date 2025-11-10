<div class="form-check form-switch">
    <input id="status_toggler_{{ $category->id }}" type="checkbox" class="form-check-input status-toggle" 
           {{ $category->is_active ? 'checked' : '' }}
           role="switch">
</div>

<script>
$(document).ready(function() {
    $('#status_toggler_{{ $category->id }}').on('change', function() {
        const isChecked = $(this).prop('checked');
        const $toggle = $(this);
        
        $.ajax({
            url: "{{ route('admin.categories.updateStatus', $category) }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                _method: 'PUT',
                is_active: isChecked ? 1 : 0,
            },
            success: function(response) {
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
