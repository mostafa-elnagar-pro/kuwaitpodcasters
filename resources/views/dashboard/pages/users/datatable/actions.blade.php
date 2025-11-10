<div class="table-act-btn gap-1">

    @permission('users-update')
        @if (!is_null($user->fcm_token))
            <x-dashboard.notify-user :item="$user">
                <button type="button" class="btn btn-outline-dark waves-effect" data-bs-toggle="modal"
                    data-bs-target="#notifyUser{{ $user->id }}">
                    <i class="bi bi-bell"></i>
                </button>
                </x-dashboard.notify-user>
        @endif
    @endpermission

    @permission('users-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.users.show', $user) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('users-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.users.edit', $user) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('users-delete')
        <x-dashboard.delete-item :item="$user" resource="users">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $user->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
