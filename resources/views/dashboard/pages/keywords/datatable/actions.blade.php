<div class="table-act-btn gap-1">
    @permission('keywords-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.keywords.show', $keyword) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('keywords-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.keywords.edit', $keyword) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('keywords-delete')
        <x-dashboard.delete-item :item="$keyword" resource="keywords">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $keyword->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
