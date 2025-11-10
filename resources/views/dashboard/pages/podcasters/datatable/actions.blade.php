<div class="table-act-btn gap-1">

    @permission('podcasters-update')
        @if (!is_null($podcaster->fcm_token))
            <x-dashboard.notify-user :item="$podcaster">
                <button type="button" class="btn btn-outline-dark waves-effect" data-bs-toggle="modal"
                    data-bs-target="#notifyUser{{ $podcaster->id }}">
                    <i class="bi bi-bell"></i>
                </button>
            </x-dashboard.notify-user>
        @endif
    @endpermission

    @permission('podcasters-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.podcasters.show', $podcaster) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('podcasters-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.podcasters.edit', $podcaster) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('podcasters-delete')
        <x-dashboard.delete-item :item="$podcaster" resource="podcasters">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $podcaster->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
