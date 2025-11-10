@php
    $general = app('settings')['general'] ?? [];
@endphp

<x-website.layout :is-header-white="true">
    <div class="main">
        <section class="terms">
            <div class="container">
                <h2 class="page-head">{{ __kw('privacy_policy', 'سياسة الخصوصية') }}</h2>
                <div class="row">
                    {{-- <div class="col-lg-6">
                        <div class="base">
                            <img alt="base" src="{{asset('website-assets/images/privacy.jpg')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="privacy-list">
                            <li>هناك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم.</li>
                            <li>وقد انتشر بشكل كبير في ستينيات القرن الماضي مع أوراق الإصدار التي تحتوي على لوريم
                                إيبسوم.</li>
                            <li>سيؤدي ذلك إلى حدوث ردود فعل حساسية للمنزل، وسيحدث هذا الخطأ عند حدوث الخطأ.</li>
                            <li>كلمات عشوائية لا تبدو قابلة للتصديق ولو قليلاً.</li>
                            <li>سيؤدي ذلك إلى حدوث ردود فعل حساسية للمنزل، وسيحدث هذا الخطأ عند حدوث الخطأ.</li>
                        </ul>
                    </div> --}}
                    {!! @$general['privacy_policy'] !!}
                </div>
            </div>
        </section>
    </div>

</x-website.layout>
