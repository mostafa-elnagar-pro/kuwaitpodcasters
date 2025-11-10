@php
    $email = request('email');
@endphp

<x-website.layout :title="__kw('reset_pwd', 'اعادة تعيين كلمة المرور')" :is-header-white="true">

    <div class="main py-4">
        <div class="container">
            <form class="auth-form" method="POST" action="{{ route('website.send-otp') }}">
                @csrf

                <img class="logo" alt="logo" src="{{ asset('website-assets/images/logo.png') }}">
                
                <h2>{{ __kw('reset_pwd', 'اعادة تعيين كلمة المرور') }}</h2>
                
                <div class="form-input">
                    <img alt="user" src="{{ asset('website-assets/images/auth-icon/user.svg') }}">
                    <input type="email" name="email"
                        placeholder="{{ __kw('enter_email', 'ادخل البريد الالكترونى') }}" required>
                </div>

                <button type="submit" class="my-btn">
                    {{ __kw('submit', 'ارسال') }}
                </button>
            </form>
        </div>
    </div>
</x-website.layout>
