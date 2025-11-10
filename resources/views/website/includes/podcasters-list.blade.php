@foreach ($podcasters as $podcaster)
    <div class="col-lg-3">
        <a href="{{ route('website.podcasters.show', $podcaster) }}" class="podqaster">
            <img class="profile-img" alt="podqaster" src="{{ displayFile($podcaster->profile_img, 'default-user.svg') }}">
            <h3>{{ $podcaster->name }}</h3>
            <!-- <span>مدير فني</span> -->
        </a>
    </div>
@endforeach
