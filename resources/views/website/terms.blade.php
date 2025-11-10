@php
    $general = app('settings')['general'] ?? [];
@endphp

<x-website.layout :is-header-white="true">
    <div class="main">
        <section class="terms">
            <div class="container">
                <h2 class="page-head">{{ __kw('terms_conditions', 'الشروط والأحكام') }}</h2>
                <div class="row">
                    {{-- <div class="col-lg-6">
                        <div class="base">
                            <img alt="base" src="{{asset('website-assets/images/terms.jpg')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="title">تقييد</h5>
                        <hr>
                        <ul>
                            <li>هناك العديد من الأشكال المتوفرة لنصوص لوريم إيبسوم، لكن الأغلبية قد عانت من التغيير بشكل
                                ما، عن طريق إدخال الفكاهة أو الكلمات العشوائية التي لا تبدو قابلة للتصديق ولو قليلاً.
                            </li>
                            <li>لكن يجب أن أشرح لك كيف ولدت كل هذه الفكرة الخاطئة المتمثلة في إدانة اللذة وتمجيد الألم،
                                وسأقدم لك وصفًا كاملاً للنظام، وأشرح التعاليم الفعلية لمستكشف الحقيقة العظيم، سيد بناء
                                الإنسان. سعادة.</li>
                            <li>ومرة أخرى لا يوجد أي شخص يحب أو يسعى أو يرغب في الحصول على الألم في حد ذاته، لأنه ألم،
                                ولكن لأنه تحدث أحيانًا ظروف يمكن فيها للكدح والألم أن يجلب له بعض المتعة العظيمة.</li>
                        </ul>
                    </div> --}}

                    {!! $general['terms_conditions'] !!}
                </div>
            </div>
        </section>
    </div>
</x-website.layout>
