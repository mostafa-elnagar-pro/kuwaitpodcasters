<div class="table-act-btn gap-1">
    @permission('seasons-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.seasons.show', $season) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('seasons-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.seasons.edit', $season) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('seasons-delete')
        <x-dashboard.delete-item :item="$season" resource="seasons">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $season->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
