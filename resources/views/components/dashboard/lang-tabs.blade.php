<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @foreach ($activeLangs as $lang)
            <button class="nav-link {{ $loop->first ? 'show active' : '' }}" id="nav-{{ $lang->abbr }}"
                data-bs-toggle="tab" data-bs-target="#{{ $lang->abbr }}" type="button" role="tab"
                aria-controls="nav-{{ $lang->abbr }}" aria-selected="true">
                {{ __("locale.$lang->abbr") }}
            </button>
        @endforeach
    </div>
</nav>
