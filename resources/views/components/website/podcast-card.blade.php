@props(['podcast'])

<div>
    <a href="{{ route('website.podcasts.show', $podcast) }}" class="podqast-card">
        <div class="icon-container">
            <img alt="icon" src="{{ asset("website-assets/images/$podcast->media_type-icon.svg") }}">
        </div>
        <img class="thumbnail" alt="podqast" src="{{ displayFile($podcast->image) }}">
        <div class="data">
            <div class="category">
                <label>{{ $podcast->podcaster?->category?->name }}</label>
                <label>
                    {{ $podcast->duration }}
                    {{ app()->currentLocale()==='ar' ? 'د' : 'm' }}
                </label>
            </div>
            <div class="content">
               {{-- <h1 class="title">{{ $podcast->name }}</h1> --}}
                <div class="about">
                    <img alt="podqaster" src="{{ displayFile($podcast->podcaster->profile_img, 'default-user.svg') }}">
                    <h5>{{ $podcast->podcaster?->name }}</h5>
                </div>
            </div>
        </div>
    </a>
</div>
