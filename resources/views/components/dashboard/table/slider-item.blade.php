@props(['slider', 'horizontal' => true])

@if ($horizontal)
    <tr>
        <td>{{ $slider->id }}</td>
        <td>
            <img src="{{ displayFile($slider->image) }}" alt="image" width="60">
        </td>
        <td>{{ formatDate($slider->created_at) }}</td>
        <td>
            <div class="table-act-btn  gap-1">
                @permission('sliders-read')
                    <button type="button" class="btn btn-outline-info waves-effect"
                        onclick="window.location.href='{{ route('admin.sliders.show', $slider) }}'">
                        <i class="bi bi-eye"></i>
                    </button>
                @endpermission

                @permission('sliders-delete')
                    <x-dashboard.delete-item :item="$slider" resource="sliders">
                        <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                            data-bs-target="#deleteRecord{{ $slider->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </x-dashboard.delete-item>
                @endpermission
            </div>
        </td>
    </tr>
@else
    <tr>
        <th>{{ __('label.image') }}</th>
        <td>
            <img src="{{ displayFile($slider->image) }}" alt="image" width="100">
        </td>
    </tr>
    <tr>
        <th>{{ __('label.created_at') }}</th>
        <td>{{ formatDate($slider->created_at) }}</td>
    </tr>
@endif
