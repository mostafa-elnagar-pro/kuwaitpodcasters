@props(['label', 'value', 'icon'])

<div class="col-xl-3 col-md-3 col-sm-4">
    <a href="#" class="card">
        <div class="after-box">
            <div class="card-body">
                <div class="media static-widget">
                    <div class="media-body">
                        <h6 class="font-roboto">{{ __("label.$label") }}</h6>
                        <h4 class="mb-0 counter">{{ $value }}</h4>
                    </div>
                    <i class="bi bi-{{ $icon }}"></i>
                </div>
            </div>
        </div>
    </a>
</div>
