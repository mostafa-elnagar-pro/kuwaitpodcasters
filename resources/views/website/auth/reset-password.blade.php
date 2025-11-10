@php
    $email = request('email');
@endphp

<x-website.layout :title="__kw('reset_pwd', 'اعادة تعيين كلمة المرور')" :is-header-white="true">

    <div class="main">
        <div class="container">
            <form class="auth-form" method="POST" action="{{ route('website.reset-pwd') }}">
                @csrf

                <img class="logo" alt="logo" src="{{ asset('website-assets/images/logo.png') }}">

                <h2>{{ __kw('reset_pwd', 'اعادة تعيين كلمة المرور') }}</h2>

                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-input">
                    <img alt="user" src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                    <input type="text" name="otp" placeholder="{{ __kw('enter_otp', 'ادخل الكود') }}" required>
                </div>

                <div class="form-input">
                    <img alt="lock" src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                    <input type="password" name="password" placeholder="{{ __kw('new_pwd', 'كلمة المرور الجديدة') }}">
                </div>

                <div class="form-input">
                    <img alt="lock" src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                    <input type="password" name="password_confirmation"
                        placeholder="{{ __kw('confirm_pwd', 'تأكيد كلمة المرور') }}">
                </div>

                <button type="submit" class="my-btn">
                    {{ __kw('submit', 'ارسال') }}
                </button>
            </form>
        </div>
    </div>
</x-website.layout>
