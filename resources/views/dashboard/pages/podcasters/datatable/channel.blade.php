@if ($podcaster->channel)
    <a href="{{ route('admin.channels.show', $podcaster->channel->id) }}">
        {{ $podcaster->channel->name }}
    </a>
@else
    __
@endif
