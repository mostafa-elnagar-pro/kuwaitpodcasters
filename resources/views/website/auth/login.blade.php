<x-website.layout :title="__('label.login')" :is-header-white="true">
    <div class="main">
        <div class="container">
            <form class="auth-form" method="POST" action="{{ route('website.login') }}">
                @csrf

                <img class="logo" alt="logo" src="{{ asset('website-assets/images/logo.png') }}">
                <h2>{{ __kw('hello', 'أهلا بك') }}</h2>
                <h2><span class="mx-1">{{ __kw('welcome', 'مرحبا') }}</span>{{ __kw('back', 'بعودتك مرة اخرى') }}</h2>
                <div class="form-input">
                    <img alt="user" src="{{ asset('website-assets/images/auth-icon/user.svg') }}">
                    <input type="text" name="email"
                        placeholder="{{ __kw('enter_email_phone', 'ادخل البريد الالكترونى او رقم الجوال') }}">
                </div>
                <div class="form-input">
                    <img alt="lock" src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                    <input type="password" name="password" placeholder="{{ __kw('enter_pwd', 'ادخل كلمة المرور') }}">
                </div>
                <div class="forget-password">
                    <a href="{{ route('website.forgot-pwd') }}">
                        {{ __kw('forgot_pwd', 'نسيت كلمة المرور ؟') }}
                    </a>
                </div>

                <button type="submit" class="my-btn">{{ __kw('login', 'تسجيل الدخول') }}</button>

                <div class="or">
                    <span>{{ __kw('or_create_account', 'أو قم بإنشاء حساب جديد') }}</span>
                </div>
                <div class="other-buttons">
                    <a href="{{ route('website.showRegisterForm', ['type' => 'user']) }}">
                        <i class="fa-regular fa-user"></i>
                        {{ __kw('create_account', 'إنشاء حساب') }}
                    </a>
                    {{-- <a href="{{ route('website.showRegisterForm', ['type' => 'user']) }}">
                        <i class="fa-regular fa-user"></i>
                        {{ __kw('create_user_account', 'إنشاء حساب مستخدم عادى') }}
                    </a> --}}
                    {{-- <a href="{{ route('website.showRegisterForm', ['type' => 'podcaster']) }}">
                        {{ __kw('create_podcaster_account', 'إنشاء حساب صانع محتوى') }}
                    </a> --}}
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        @push('js')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "{{ __kw('success', 'تم بنجاح') }}",
                    text: "{{ __kw('register_success_message', 'شكرًا لانضمامك إلينا.') }}",
                    confirmButtonText: "{{ __kw('ok', 'حسناً') }}"
                }).then(() => {
                    $("#contactForm").trigger("reset");
                });
            </script>
        @endpush
    @endif
</x-website.layout>
