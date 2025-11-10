@props(['name', 'details'])


<div class="col-md-4 col-12">
    <div class="mb-1">
        <label class="form-label" for="{{ $name }}">
            {{ __("label.$name") }}
        </label>
        <input type="text" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $details->$name ?? null) }}"
            class="form-control" placeholder="{{ __("label.$name") }}" />
    </div>
</div>
