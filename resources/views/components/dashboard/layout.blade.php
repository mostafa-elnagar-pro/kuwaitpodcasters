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
</head>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">


    @include('dashboard.includes.header')


    @include('dashboard.includes.all_aside')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                @yield('breadcrumb')
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                {{ $slot }}
                <!-- Dashboard Ecommerce ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('dashboard.includes.footer')

    @include('dashboard.includes.js')

</body>

</html>
