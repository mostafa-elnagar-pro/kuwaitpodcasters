<div class="table-act-btn gap-1">
    @permission('channels-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.channels.show', $channel) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('channels-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.channels.edit', $channel) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('channels-delete')
        <x-dashboard.delete-item :item="$channel" resource="channels">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $channel->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
