@props(['general'])

@php
    $social_links = [
        'facebook' => 'facebook',
        'linkedin' => 'linkedin',
        'twitter' => 'x',
        'instagram' => 'instagram',
        'youtube' => 'youtube',
        'snapchat' => 'snapchat',
        'tiktok' => 'tiktok',
    ];
@endphp

<section class="contact-us wow fadeInUp" data-wow-delay="0.4s">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="info">
                    <h3>{{ __kw('contact_info', 'بيانات التواصل') }}</h3>
                    @isset($general['website_address'])
                        <div class="item">
                            <i class="fa-solid fa-location-dot"></i>
                            <div>
                                <span>{{ __kw('address', 'العنوان') }}</span>
                                <p>{{ $general['website_address'] }}</p>
                            </div>
                        </div>
                    @endisset

                    @isset($general['website_phone'])
                        <div class="item">
                            <i class="fa-solid fa-phone-volume"></i>
                            <div>
                                <span>{{ __kw('phone', 'رقم الهاتف') }}:</span>
                                <a href="tel:{{ @$general['website_phone'] }}">{{ @$general['website_phone'] }}</a>
                            </div>
                        </div>
                    @endisset

                    @isset($general['website_email'])
                        <div class="item">
                            <i class="fa-solid fa-envelope"></i>
                            <div>
                                <span>{{ __kw('email', 'البريد الالكتروني') }}:</span>
                                <a href="mailto:info@poscast.com">{{ @$general['website_email'] }}</a>
                            </div>
                        </div>
                    @endisset

                    <div class="social-buttons">
                        @foreach ($social_links as $key => $icon)
                            @isset($general["{$key}_link"])
                                <a href="{{ $general["{$key}_link"] }}" target="blank">
                                    <img alt="{{ $icon }}"
                                        src="{{ asset("website-assets/images/socials/{$icon}.svg") }}" width="30px">
                                </a>
                            @endisset
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <form id="contactForm">
                    <h3>{{ __kw('have_any_question', 'لديك اي استفسار ؟ تواصل معنا') }}</h3>
                    <div class="two-inputs">
                        <input type="text" id="name" placeholder="{{ __kw('name', 'الاسم') }}" required>
                        <input type="number" id="phone" placeholder="{{ __kw('enter_phone', 'ادخل رقم الهاتف') }}"
                            required>
                    </div>
                    <input type="email" id="email" placeholder="{{ __kw('email', 'البريد الالكترونى') }}"
                        required>
                    <textarea id="message" placeholder="{{ __kw('message', 'الرسالة') }}" required></textarea>
                    <button type="submit" class="my-btn">
                        {{ __kw('send', 'ارسال') }}
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>



@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '/api/contact',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        isWeb: true,
                        name: $('#name').val(),
                        phone: $('#phone').val(),
                        email: $('#email').val(),
                        message: $('#message').val(),
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: "{{ __kw('success', 'تم بنجاح') }}",
                            text: "{{ __kw('contact_us_msg', 'شكرًا لتواصلك معنا. سنعاود الاتصال بك قريبًا.') }}",
                         confirmButtonText: "{{ __kw('ok', 'حسناً') }}"
                        }).then(() => {
                            $("#contactForm").trigger("reset");
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __kw('error_occurred', 'حدث خطأ ما') }}",
                            confirmButtonText: "{{ __kw('ok', 'حسناً') }}"
                        })
                    }
                });
            });
        });
    </script>
@endpush
               