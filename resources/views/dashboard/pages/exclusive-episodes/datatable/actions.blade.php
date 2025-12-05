<div class="table-act-btn gap-1">
    @permission('exclusive-episodes-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.exclusive-episodes.show', $episode) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('exclusive-episodes-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.exclusive-episodes.edit', $episode) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('exclusive-episodes-delete')
        <x-dashboard.delete-item :item="$episode" resource="exclusive-episodes">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $episode->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>

