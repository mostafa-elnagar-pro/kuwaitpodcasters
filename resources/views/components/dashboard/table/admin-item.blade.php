@props(['admin', 'horizontal' => true])

@if ($horizontal)
    <tr>
        <td>{{ $admin->id }}</td>
        <td>{{ $admin->name }}</td>
        <td>{{ $admin->email }}</td>
        <td>{{ formatDate($admin->created_at) }}</td>
        <td>
            <div class="table-act-btn  gap-1">
                @permission('admins-read')
                    <button type="button" class="btn btn-outline-info waves-effect"
                        onclick="window.location.href='{{ route('admin.admins.show', $admin) }}'">
                        <i class="bi bi-eye"></i>
                    </button>
                @endpermission

                @if ($admin->id !== 1)
                    @permission('admins-update')
                        <button type="button" class="btn btn-outline-success waves-effect"
                            onclick="window.location.href='{{ route('admin.admins.edit', $admin) }}'">
                            <i class="bi bi-pencil"></i>
                        </button>
                    @endpermission

                    @permission('admins-delete')
                        <x-dashboard.delete-item :item="$admin" resource="admins">
                            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                                data-bs-target="#deleteRecord{{ $admin->id }}">
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
        <th>{{ __('label.name') }}</th>
        <td>{{ $admin->name }}</td>
    </tr>

    <tr>
        <th>{{ __('label.email') }}</th>
        <td>{{ $admin->email }}</td>
    </tr>

    <tr>
        <th>{{ __('label.role') }}</th>
        <td>
            <span class="badge badge-primary">{{ ucfirst($admin->roles->first()->name) }}</span>
        </td>
    </tr>

    <tr>
        <th>{{ __('label.created_at') }}</th>
        <td>{{ formatDate($admin->created_at) }}</td>
    </tr>
@endif
