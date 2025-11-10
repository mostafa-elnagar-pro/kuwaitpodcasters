@props(['language', 'horizontal' => true])

@if ($horizontal)
    <tr>
        <td>
            <div class="form-check form-check-inline">
                <input class="form-check-input items" name="items[]" type="checkbox" value="{{ $language->id }}">
            </div>
        </td>
        <td>{{ $language->id }}</td>
        <td>
            <span class="fs-3 flag-icon flag-icon-{{ $language->flag }}"></span>
        </td>
        <td>{{ $language->name }}</td>
        <td>{{ $language->abbr }}</td>
        <td>{{ strtoupper($language->direction) }}</td>
        <td>
            @if ($language->is_active)
                <i class="fs-3 bi bi-check-circle-fill text-success"></i>
            @else
                <i class="fs-3 bi bi-x-circle-fill text-danger"></i>
            @endif
        </td>
        <td>{{ formatDate($language->created_at) }}</td>
        <td>
            <div class="table-act-btn  gap-1">
                @permission('languages-read')
                    <button type="button" class="btn btn-outline-info waves-effect"
                        onclick="window.location.href='{{ route('admin.languages.show', $language) }}'">
                        <i class="bi bi-eye"></i>
                    </button>
                @endpermission

                @permission('languages-update')
                    <button type="button" class="btn btn-outline-success waves-effect"
                        onclick="window.location.href='{{ route('admin.languages.edit', $language) }}'">
                        <i class="bi bi-pencil"></i>
                    </button>
                @endpermission

                @permission('languages-delete')
                    <x-dashboard.delete-item :item="$language" resource="languages">
                        <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                            data-bs-target="#deleteRecord{{ $language->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </x-dashboard.delete-item>
                @endpermission
            </div>
        </td>
    </tr>
@else
    <tr>
        <th>{{ __('label.name') }}</th>
        <td>{{ $language->name }}</td>
    </tr>

    <tr>
        <th>{{ __('label.abbr') }}</th>
        <td>{{ $language->abbr }}</td>
    </tr>

    <tr>
        <th>{{ __('label.direction') }}</th>
        <td>{{ __("label.$language->direction") }}</td>
    </tr>

    <tr>
        <th>{{ __('label.status') }}</th>
        <td>
            @if ($language->is_active)
                <i class="fs-3 bi bi-check-circle-fill text-success"></i>
            @else
                <i class="fs-3 bi bi-x-circle-fill text-danger"></i>
            @endif
        </td>
    </tr>

    <tr>
        <th>{{ __('label.created_at') }}</th>
        <td>{{ formatDate($language->created_at) }}</td>
    </tr>
@endif
