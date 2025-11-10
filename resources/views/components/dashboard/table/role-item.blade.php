@props(['role', 'horizontal' => true])

@if ($horizontal)
    <tr>
        <td>{{ $role->id }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <div class="table-act-btn gap-1">
                @permission('roles-read')
                    <button type="button" class="btn btn-outline-info waves-effect"
                        onclick="window.location.href='{{ route('admin.roles.show', $role) }}'">
                        <i class="bi bi-eye"></i>
                    </button>
                @endpermission

                @if ($role->name !== 'admin')
                    @permission('roles-update')
                        <button type="button" class="btn btn-outline-success waves-effect"
                            onclick="window.location.href='{{ route('admin.roles.edit', $role) }}'">
                            <i class="bi bi-pencil"></i>
                        </button>
                    @endpermission

                    @permission('roles-delete')
                        <x-dashboard.delete-item :item="$role" resource="roles">
                            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                                data-bs-target="#deleteRecord{{ $role->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </x-dashboard.delete-item>
                    @endpermission
                @endif
            </div>
        </td>
    </tr>
@else
    <tr>
        <th>#</th>
        <td>{{ $role->id }}</td>
    </tr>

    <tr>
        <th>{{ __('label.name') }}</th>
        <td>{{ $role->name }}</td>
    </tr>

    <tr>
        <th>{{ __('label.created_at') }}</th>
        <td>{{ formatDate($role->created_at) }}</td>
    </tr>

    <tr>
        <th>{{ __('label.permissions') }}</th>
        <td class="d-flex flex-wrap gap-50">
            @foreach ($role->permissions as $permission)
                <span class="badge badge-primary">{{ $permission->name }}</span>
            @endforeach
        </td>
    </tr>
@endif
