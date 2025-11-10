@php
    $settings = app('settings');
    $countries = $settings['countries'] ?? [];
    $categories = $settings['categories'] ?? [];
    $isPodcaster = $user->type === 'podcaster';
@endphp

<x-website.layout>
    <div class="main">
        <div class="barcrumb">
            <h1>{{ __kw('profile', 'الملف الشخصى') }}</h1>
            <div>
                <a href="index.html">{{ __kw('home', 'الرئيسية') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ $user->name }}</span>
            </div>
        </div>
        <div class="container">
            <div class="profile row wow fadeInUp" data-wow-delay="0.4s">
                <div class="col-lg-3">
                    <div class="image">
                        <img id="profileImgPreview" alt="podcaster"
                            src="{{ displayFile($user->profile_img, 'default-user.svg') }}"
                            style="border-radius:50%;object-fit:cover;">

                        <button type="button" id="uploadButton"><i class="fa-regular fa-pen-to-square"></i></button>

                        <form id="imageUploadForm" method="POST" action="{{ route('website.profile.update') }}"
                            enctype="multipart/form-data" style="display: none;">
                            @csrf

                            @method('PUT')

                            <input type="file" id="profileImageInput" name="profile_img" accept="image/*"
                                style="display: none;">
                        </form>
                    </div>
                    <ul class="nav" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                data-bs-target="#personal" type="button" role="tab" aria-controls="personal"
                                aria-selected="true">{{ __kw('profile', 'الملف الشخصى') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                                type="button" role="tab" aria-controls="password" aria-selected="false">
                                {{ __kw('password', 'كلمة المرور') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="wish-tab" data-bs-toggle="tab" data-bs-target="#wish"
                                type="button" role="tab" aria-controls="wish" aria-selected="false">
                                {{ __kw('my_favourite', 'مفضلتى') }}
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <form action="{{ route('website.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout">
                                    {{ __kw('logout', 'تسجيل الخروج') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                            aria-labelledby="personal-tab">
                            <form class="auth-form" method="POSt" action="{{ route('website.profile.update') }}">
                                @csrf

                                @method('PUT')

                                <input type="hidden" name="source" value="web">

                                <div class="form-flex">
                                    <div class="form-input">
                                        <img alt="user"
                                            src="{{ asset('website-assets/images/auth-icon/user.svg') }}">
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            placeholder="{{ __kw('name', 'الاسم') }}" required>
                                    </div>
                                    <div class="form-input">
                                        <img alt="email"
                                            src="{{ asset('website-assets/images/auth-icon/email.svg') }}">
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            placeholder="{{ __kw('email', 'البريد الالكترونى') }}" required>
                                    </div>
                                </div>
                                <div class="form-flex">
                                    <div class="form-input">
                                        <div class="select-country">
                                            <select id="select2WithImgOption" name="country"
                                                class="select2 country__select">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->code . '@' . $country->id }}"
                                                        data-img="{{ displayFlag($country->flag) }}"
                                                        @selected(old('country', $user->country->code . '@' . $user->country->id) == $country->code . '@' . $country->id)>
                                                        {{ $country->code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input class="phone-number" type="text" name="phone"
                                            value="{{ old('phone', ltrim($user->phone, $user->country->code)) }}"
                                            placeholder="{{ __kw('phone', 'رقم الهاتف') }}">
                                    </div>
                                    {{-- @if ($isPodcaster)
                                        <div class="form-input">
                                            <img alt="category"
                                                src="{{ asset('website-assets/images/auth-icon/category.svg') }}">
                                            <select class="select2" name="category_id">
                                                <option selected disabled>
                                                    {{ __kw('select_your_category', 'اختر التصنيف الخاص بك') }}
                                                </option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected(old('category_id', $user->podcasterDetails->category->id) == $category->id)>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif --}}
                                </div>
                                {{-- @if ($isPodcaster)
                                    <div class="form-input">
                                        <textarea name="bio" placeholder={{ __kw('bio', 'نبذة صغيره عنك') }}>{{ old('bio', $user->podcasterDetails->bio) }}</textarea>
                                    </div>

                                    <div class="form-flex">
                                        <div class="form-input">
                                            <img alt="facebook"
                                                src="{{ asset('website-assets/images/socials/facebook.svg') }}">
                                            <input type="text" name="facebook"
                                                value="{{ old('facebook', $user->podcasterDetails->facebook) }}">
                                        </div>
                                        <div class="form-input">
                                            <img alt="facebook"
                                                src="{{ asset('website-assets/images/socials/insta.svg') }}">
                                            <input type="text" name="instagram"
                                                value="{{ old('instagram', $user->podcasterDetails->instagram) }}">
                                        </div>
                                    </div>
                                    <div class="form-flex">
                                        <div class="form-input">
                                            <img alt="facebook"
                                                src="{{ asset('website-assets/images/socials/snapchat.svg') }}">
                                            <input type="text" name="snapchat"
                                                value="{{ old('snapchat', $user->podcasterDetails->snapchat) }}">
                                        </div>
                                        <div class="form-input">
                                            <img alt="facebook"
                                                src="{{ asset('website-assets/images/socials/youtube.svg') }}">
                                            <input type="text" name="youtube"
                                                value="{{ old('youtube', $user->podcasterDetails->youtube) }}">
                                        </div>
                                    </div>
                                    <div class="form-flex">
                                        <div class="form-input">
                                            <img alt="facebook"
                                                src="{{ asset('website-assets/images/socials/tiktok.svg') }}">
                                            <input type="text" name="tiktok"
                                                value="{{ old('tiktok', $user->podcasterDetails->tiktok) }}">
                                        </div>
                                        <div class="form-input">
                                            <img alt="facebook"
                                                src="{{ asset('website-assets/images/socials/x.svg') }}">
                                            <input type="text" name="twitter"
                                                value="{{ old('twitter', $user->podcasterDetails->twitter) }}">
                                        </div>
                                    </div>
                                @endif --}}
                                <button type="submit" class="my-btn">{{ __kw('save', 'حفظ') }}</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form class="auth-form" method="POST" action="{{ route('website.profile.update') }}">
                                @csrf

                                @method('PUT')

                                <input type="hidden" name="source" value="web">

                                <div class="form-input">
                                    <img alt="lock"
                                        src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                                    <input type="password" name="current_password"
                                        placeholder="{{ __kw('current_pwd', 'كلمة المرور الحالية') }}">
                                </div>
                                <div class="form-input">
                                    <img alt="lock"
                                        src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                                    <input type="password" name="password"
                                        placeholder="{{ __kw('new_pwd', 'كلمة المرور الجديدة') }}">
                                </div>
                                <div class="form-input">
                                    <img alt="lock"
                                        src="{{ asset('website-assets/images/auth-icon/lock.svg') }}">
                                    <input type="password" name="password_confirmation"
                                        placeholder="{{ __kw('confirm_pwd', 'تأكيد كلمة المرور') }}">
                                </div>

                                <button type="submit" class="my-btn">
                                    {{ __kw('save', 'حفظ') }}
                                </button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="wish" role="tabpanel" aria-labelledby="wish-tab">
                            <div id="podcasts_container" class="row">
                                <!-- podcasts inserted dynamically by ajax -->
                            </div>

                            @if ($user->favourites_count === 0)
                                <div class="py-5 text-center">
                                    <img class="w-h-100 m-auto my-4" alt="empty"
                                        src="{{ asset('website-assets/images/empty-podcast.png') }}" />
                                    <p class="text-secondary fs-5">
                                        {{ __kw('no_favourites_found', 'لم يتم اضافة حلقات في المفضلة') }}
                                    </p>
                                </div>
                            @endif

                            <div id="loading" class="my-3" style="display:none;">
                                <div class="loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('css')
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/admin/app-assets/vendors/css/forms/select/select2.min.css') }}">
    @endpush

    @push('js')
        <script src="{{ asset('assets/admin/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/admin/app-assets/js/scripts/forms/form-select2.min.js') }}"></script>
        <x-scripts.infinite-scroll-loader />
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


                // handle active tab
                function getQueryParam(param) {
                    var urlParams = new URLSearchParams(window.location.search);
                    return urlParams.get(param);
                }

                var activeTab = getQueryParam('tab');
                if (activeTab) {
                    $('#myTab button[data-bs-target="#' + activeTab + '"]').tab('show');
                } else {
                    $('#myTab button[data-bs-target="#personal"]').tab('show');
                }

                $('#myTab button').on('shown.bs.tab', function(e) {
                    var target = $(e.target).data('bs-target').substring(1);
                    var newUrl = window.location.protocol + "//" + window.location.host + window.location
                        .pathname + '?tab=' + target;
                    history.pushState(null, null, newUrl);
                });


                // When the button is clicked, trigger the file input
                $('#uploadButton').on('click', function() {
                    $('#profileImageInput').click();
                });

                // When a file is selected, update the image preview
                $('#profileImageInput').on('change', function() {
                    var input = this;
                    var file = input.files[0];

                    if (file) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#profileImgPreview').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(file);
                    }

                    $('#imageUploadForm').submit();
                });

                if (activeTab === 'wish') {
                    // get favourites
                    var apiUrl = `{{ route('website.podcasts.index') }}`;
                    var apiUrlWithFilter = `${apiUrl}?filter=favourite`;

                    infiniteScrollLoader(apiUrlWithFilter, '#podcasts_container', true);
                }

            });
        </script>
    @endpush
</x-website.layout>
