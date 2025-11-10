@php
    $settings = app('settings');
    $countries = $settings['countries'] ?? [];
    $categories = $settings['categories'] ?? [];
    $isPodcaster = $type === 'podcaster';
@endphp

<x-website.layout :title="__('label.register')" :is-header-white="true">
    <div class="main">
        <div class="container">
            <form class="auth-form" method="POST" action="{{ route('website.register') }}">
                @csrf

                <img class="logo" alt="logo" src="{{ asset('website-assets/images/logo.png') }}">
                <h2>
                    {{ $isPodcaster ? __kw('publish_thoughts', 'انشر جميع افكارك') : __kw('start_special_journey', 'ابدأ رحلتلك المميزة') }}
                </h2>
                <h2>
                    <span>
                        {{ $isPodcaster ? __kw('as_podcaster', 'كصانع محتوى') : __kw('with_podcast', 'مع البودكاست') }}
                    </span>
                    {{ __kw('register_now', 'و سجل الان') }}
                </h2>
                <div class="form-input">
                    <img alt="user" src="{{ asset('website-assets/images/auth-icon/user.svg') }}">
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="{{ __kw('enter_full_name', 'ادخل اسمك بالكامل') }}">
                </div>

                <input type="hidden" name="type" value="{{ $type }}" />

                <div class="form-input">
                    <div class="select-country">
                        <select id="select2WithImgOption" name="country" class="select2 country__select">
                            @foreach ($countries as $country)
                                <option value="{{ $country->code . '@' . $country->id }}"
                                    data-img="{{ displayFlag($country->flag) }}" @selected(old('country') == $country->code . '@' . $country->id)>
                                    {{ $country->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input class="phone-number" name="phone" type="number" value="{{ old('phone') }}"
                        placeholder="{{ __kw('enter_phone', 'ادخل رقم الهاتف') }}" class='px-5'>
                </div>
                <div class="form-input">
                    <img alt="email" src="{{ asset('website-assets/images/auth-icon/email.svg') }}">
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="{{ __kw('enter_your_email', 'ادخل البريد الالكترونى') }}">
                </div>

                @if ($isPodcaster)
                    <div class="form-input">
                        <img alt="category" src="{{ asset('website-assets/images/auth-icon/category.svg') }}">
                        <select class="select2" name="category_id">
                            <option selected disabled>
                                {{ __kw('select_your_category', 'اختر التصنيف الخاص بك') }}
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-input">
                        <textarea name="bio" value="{{ old('bio') }}" placeholder="{{ __kw('enter_bio', 'اكتب نبذة صغيره عنك') }}"></textarea>
                    </div>
                @endif

                <div class="form-input">
                    <img alt="lock" src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                    <input type="password"name="password" placeholder="{{ __kw('enter_pwd', 'ادخل كلمة المرور') }}">
                </div>
                <div class="form-input">
                    <img alt="lock" src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                    <input type="password" name="password_confirmation"
                        placeholder="{{ __kw('confirm_pwd', 'تأكيد كلمة المرور') }}">
                </div>
                <div class="d-flex">
                    <input type="checkbox" id="accept-terms" name="accept-terms" value="yes">
                    <label class="mx-2" for="accept-terms">
                        {{ __kw('agree_terms_conditions', 'أوافق على الشروط والاحكام') }}
                    </label>
                </div>
                <button type="submit" class="my-btn">
                    {{ __kw('create_new_account', 'انشاء حساب جديد') }}
                </button>
                <p class="have-account">
                    {{ __kw('already_have_account', 'امتلك حساب بالفعل') }}
                    <a href="{{ route('website.showLoginForm') }}">{{ __kw('login', 'تسجيل الدخول') }}</a>
                </p>
            </form>
        </div>
    </div>


    @push('css')
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/admin/app-assets/vendors/css/forms/select/select2.min.css') }}">
    @endpush

    @push('js')
        <script src="{{ asset('assets/admin/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/admin/app-assets/js/scripts/forms/form-select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                function formatOption(option) {
                    if (!option.id) {
                        return option.text;
                    }
                    const imgSrc = $(option.element).data('img');
                    const $option = $(
                        `<span><img src="${imgSrc}" style="width: 20px; height: 20px;display:inline-block; border-radius:50%;"><span>${option.text}</span></span>`
                    );
                    return $option;
                }

                $('#select2WithImgOption').select2({
                    minimumResultsForSearch: Infinity,
                    templateResult: formatOption,
                    templateSelection: formatOption
                });
            });
        </script>
    @endpush
</x-website.layout>
