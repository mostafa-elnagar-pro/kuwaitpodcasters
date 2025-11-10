@props(['setting', 'horizontal' => true])

@if ($horizontal)
    <tr>
        <td>{{ $setting->id }}</td>
        <td>{{ __("label.$setting->type") }}</td>
        <td>{{ $setting->key }}</td>
        <td>
            <div class="table-act-btn gap-1">
                @permission('settings-read')
                    <button type="button" class="btn btn-outline-info waves-effect"
                        onclick="window.location.href='{{ route('admin.settings.show', $setting) }}'">
                        <i class="bi bi-eye"></i>
                    </button>
                @endpermission

                @permission('settings-update')
                    <button type="button" class="btn btn-outline-success waves-effect"
                        onclick="window.location.href='{{ route('admin.settings.edit', [$setting, 'key' => $setting->type]) }}'">
                        <i class="bi bi-pencil"></i>
                    </button>
                @endpermission

                @permission('settings-delete')
                    <x-dashboard.delete-item :item="$setting" resource="settings">
                        <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                            data-bs-target="#deleteRecord{{ $setting->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </x-dashboard.delete-item>
                @endpermission
            </div>
        </td>
    </tr>
@else
    <tr>
        <th class="w-25">#</th class="w-25">
        <td class="w-75">{{ $setting->id }}</td>
    </tr>

    <tr>
        <th class="w-25">{{ __('label.key') }}</th class="w-25">
        <td class="w-75">{{ $setting->key }}</td>
    </tr>

    <tr>
        <th class="w-25">{{ __('label.type') }}</th class="w-25">
        <td class="w-75">{{ __("label.$setting->type") }}</td>
    </tr>

    <tr>
        <th class="w-25">{{ __('label.value') }}</th class="w-25">
        <td class="w-75">
            @if ($setting->type === 'trans_text')
                {!! $setting->trans_value !!}
            @elseif($setting->type === 'text')
                {{ $setting->value }}
            @elseif ($setting->type === 'audio')
                <audio controls>
                    <source src="{{ displayFile($setting->value) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            @elseif ($setting->type === 'image')
                <img src="{{ displayFile($setting->value) }}" alt="image" style="max-width:300px;">
            @else
                <video controls style="max-width:400px;">
                    <source src="{{ displayFile($setting->value) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
        </td>
    </tr>
@endif
