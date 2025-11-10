@foreach ($channels as $channel)
    <div class="col-lg-3">
        <a class="chanal-card" href="{{ route('website.channels.show', $channel) }}">
            <img class="thumbnail" alt="channel" src="{{ displayFile($channel->image) }}">
            <div class="content">
                <span class="info">{{ $channel->name }}</span>
            </div>
        </a>
    </div>
@endforeach
