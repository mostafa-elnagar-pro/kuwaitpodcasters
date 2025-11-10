<!DOCTYPE html>
<html class="loading light-layout" lang="ar" data-textdirection="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Podcasters admin dashboard.">
    <meta name="keywords" content="admin dashboard, podcasters admin dashboard, dashboard, web dashboard">
    <meta name="author" content="Mohamed Abdelwahed">

    <title>{{ $title ?? 'Podcaster' }}</title>

    @include('dashboard.includes.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/css/pages/authentication.css') }}">
</head>

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static" data-open="click"
    data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <a class="brand-logo" href="javascript:;">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                        </a>

                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-3">
                                    {{ __('messages.welcomeToPodcaster') }}
                                </h2>

                                <form method="POST" action="{{ route('admin.login') }}" class="mt-2">
                                    @csrf

                                    <div class="mb-1 parent">
                                        <label class="form-label" for="login-email">{{ __('label.email') }}</label>
                                        <input class="form-control" id="login-email" type="text" name="email"
                                            placeholder="john@example.com" aria-describedby="login-email" autofocus=""
                                            tabindex="1" />
                                    </div>

                                    <div class="mb-1 parent ">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label"
                                                for="login-password">{{ __('label.password') }}</label>
                                        </div>

                                        <x-dashboard.password-input />
                                    </div>

                                    <button class="btn btn-dark btn-lg w-100 mt-2" tabindex="4">
                                        {{ __('action.login') }}
                                    </button>
                                </form>

                            </div>
                        </div>
                        <!-- /Login-->

                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <x-dashboard.login-gif />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.includes.js')

</body>

</html>
