<option value="all">{{ __('label.all') }}</option>
@foreach ($seasons as $season)
    <option value="{{ $season->id }}">
        {{ $season->name }}
    </option>
@endforeach
