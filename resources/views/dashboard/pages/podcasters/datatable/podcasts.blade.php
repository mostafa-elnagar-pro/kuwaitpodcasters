<div class="d-flex gap-1 justify-content-center">
    <span class="badge bg-dark">
        {{ $podcaster->podcasts_count . ' ' . __('label.podcasts') }}
    </span>

    @if ($podcaster->videos_count > 0)
        <span class="badge" style="background:#FF6384;">
            {{ $podcaster->videos_count . ' ' . __('label.videos') }}
        </span>
    @endif

    @if ($podcaster->audios_count > 0)
        <span class="badge" style="background:#FFCE56;">
            {{ $podcaster->audios_count . ' ' . __('label.audios') }}
        </span>
    @endif
</div>
