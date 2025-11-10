<div class="table-act-btn gap-1">
    @permission('feedbacks-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.feedbacks.show', $feedback) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission
    @permission('feedbacks-delete')
        <x-dashboard.delete-item :item="$feedback" resource="feedbacks">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $feedback->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
