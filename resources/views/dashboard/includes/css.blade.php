<link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/admin/app-assets/images/ico/favicon.ico') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/vendors/css/vendors-rtl.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/css-rtl/bootstrap-icons.css') }}">

<!-- Cairo Font -->
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
<!-- / Cairo Font -->

<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/css-rtl/plugins/extensions/ext-component-toastr.css') }}">

<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/css-rtl/pages/dashboard-ecommerce.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/css-rtl/plugins/charts/chart-apex.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/assets/css/style.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/admin/assets/plugins/flags.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/vendors/css/vendors.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/css/plugins/forms/form-file-uploader.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/css-rtl/colors.css') }}">
@if (app()->getLocale() == 'en')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/admin/app-assets/css-rtl/bootstrap-extended-en.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu-en.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/css-rtl/components-en.css') }}">
@else
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/css-rtl/bootstrap-rtl.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/admin/app-assets/css-rtl/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/css-rtl/components.css') }}">
@endif
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/app-assets/css-rtl/themes/dark-layout.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/admin/app-assets/css-rtl/themes/semi-dark-layout.css') }}">

@vite('resources/css/app.css')


@stack('css')
