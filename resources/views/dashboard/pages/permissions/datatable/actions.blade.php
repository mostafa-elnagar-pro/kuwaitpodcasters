@unless (in_array($permission->group, ['admins', 'roles', 'permissions']))
    <div class="table-act-btn gap-1">
        @permission('permissions-delete')
            <x-dashboard.delete-item :item="$permission" resource="permissions">
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                    data-bs-target="#deleteRecord{{ $permission->id }}">
                    <i class="bi bi-trash"></i>
                </button>
            </x-dashboard.delete-item>
        @endpermission
    </div>
@endunless
