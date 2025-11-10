@props(['resource', 'icon', 'showCreate' => true, 'hasSub' => true, 'subList' => null])


@php
    $prefix = app()->currentLocale() . '/' . 'dashboard';
@endphp


@permission("$resource-read")
    @if ($hasSub)
        <li class="has-sub  {{ activePath(["$prefix/$resource"]) == 'active' ? 'open' : '' }}">
            <a class="d-flex align-items-center active" href="#">
                <i class="{{ $icon }}"></i>
                <span class="menu-item">
                    {{ __("label.$resource") }}
                </span>
            </a>
            <ul class="menu-content">
                @if (is_null($subList))
                    <li class="{{ activePath(["$prefix/$resource"]) }}">
                        <a class="d-flex align-items-center" href="{{ route("admin.$resource.index") }}">
                            <span class="menu-item" data-i18n="Basic">
                                {{ __("label.$resource") }}
                            </span>
                        </a>
                    </li>
                @else
                    @foreach ($subList as $item)
                        <li class="{{ activePath(["$prefix/$resource/$item"]) }}">
                            <a class="d-flex align-items-center" href="{{ route("admin.$resource.index", ['type' => $item]) }}">
                                <span class="menu-item" data-i18n="Basic">
                                    {{ __("label.{$item}s") }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                @endif
                @if ($showCreate)
                    @permission("$resource-create")
                        <li class="{{ activePath(["$prefix/$resource/create"]) }}">
                            <a class="d-flex align-items-center" href="{{ route("admin.$resource.create") }}">
                                <span class="menu-item" data-i18n="Cover">
                                    {{ __('action.add_new') }}
                                </span>
                            </a>
                        </li>
                    @endpermission
                @endif
            </ul>
        </li>
    @else
        <li class="{{ activePath(["$prefix/$resource"]) }}">
            <a class="d-flex align-items-center" href="{{ route("admin.$resource.index") }}">
                <i class="{{ $icon }}"></i>
                <span class="menu-item">
                    {{ __("label.$resource") }}
                </span>
            </a>
        </li>
    @endif

@endpermission
