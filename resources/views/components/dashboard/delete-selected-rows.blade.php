{{ $slot }}

<!-- Confirm Delete Modal -->
<div class="modal fade" id="deleteSelectedRows" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-xl">{{ __('label.confirm_delete') }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex">
                <h5>{{ __('messages.confirmMultiDelete') }}</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn w-inherit" data-bs-dismiss="modal">
                    {{ __('action.cancel') }}
                </button>
                <button type="submit" form="bulk_delete_form" class="btn btn-danger w-inherit">
                    {{ __('action.confirm') }}
                </button>
            </div>
        </div>
    </div>
</div>
