@php
    $general = app('settings')['general'] ?? [];
@endphp

<x-website.layout :is-header-white="true">

    <div class="main">
        <section class="overview mt-5">
            <div class="container">
                <div class="row">
                    @isset($general['about_app_image'])
                        <div class="col-lg-6">
                            <img alt="overview" src="{{ $general['about_app_image'] }}" class="first-img wow fadeInDown"
                                data-wow-delay="0.6s">
                        </div>
                    @endisset

                    <div class="col-lg-6">
                        <div class="content">
                            <h2>{{ __kw('about_us', 'من نحن') }}</h2>
                            <p>
                                {!! @$general['about_app'] !!}
                            </p>
                        </div>
                    </div>

                </div>
                <ul class="nav mt-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="mission-tab" data-bs-toggle="tab" data-bs-target="#mission"
                            type="button" role="tab" aria-controls="mission"
                            aria-selected="false">{{ __kw('about_mission_1', 'مهمتنا') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vision-tab" data-bs-toggle="tab" data-bs-target="#vision"
                            type="button" role="tab" aria-controls="vision"
                            aria-selected="false">{{ __kw('about_mission_2', 'رؤيتنا') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="value-tab" data-bs-toggle="tab" data-bs-target="#value"
                            type="button" role="tab" aria-controls="value"
                            aria-selected="false">{{ __kw('about_mission_3', 'قيمنا') }}</button>
                    </li>
                </ul>
                <div class="tab-content py-4 px-lg-5" id="myTabContent">
                    <div class="tab-pane fade show active" id="mission" role="tabpanel" aria-labelledby="mission-tab">
                        <div class="content">
                            <p>{!! @$general['about_mission_1'] !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="vision" role="tabpanel" aria-labelledby="vision-tab">
                        <div class="content">
                            <p>{!! @$general['about_mission_2'] !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="value" role="tabpanel" aria-labelledby="value-tab">
                        <div class="content">
                            <p>{!! @$general['about_mission_3'] !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

</x-website.layout>
