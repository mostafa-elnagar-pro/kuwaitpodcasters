<!-- BEGIN: Vendor JS-->
<script src="{{ asset('assets/admin/app-assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
{{-- <script src="{{asset('assets/admin')}}/assets/admin/app-assets/vendors/js/charts/apexcharts.min.js"></script> --}}
<script src="{{ asset('assets/admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('assets/admin/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/js/core/app.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('assets/admin/app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
<!-- END: Page JS-->


{{-- <script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/admin/app-assets/js/scripts/tables/table-datatables-advanced.js') }}"></script> --}}


<script src="{{ asset('assets/plugins/form-validator/jquery.form-validator.js') }}"></script>

{{-- datatable --}}


<script src="{{ asset('assets/admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('assets/admin/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
{{-- <script src="{{ asset('assets/admin/app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script> --}}

<script src="{{ asset('assets/admin/assets/plugins/fontawesome.js') }}" crossorigin="anonymous"></script>
{{-- <script src="{{asset('assets/admin/assets/plugins/axios.js')}}"></script> --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icons/6.7.0/css/flag-icons.min.css"
    integrity="sha512-s/Nra58/et4CDKSnhUiPrce+8M5tdK1Ps0+9dKe4I9JH/g0QGzsPAdf1fLeBsMTMG1zWMBsnzxvPgTOAFUHwLQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="{{ asset('assets/admin/app-assets/js/scripts/speakingurl.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/file-uploaders/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/js/scripts/echarts.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/calendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/calendar/ar-sa.js') }}"></script>
{{-- @include('dashboard.includes.axios') --}}
@include('dashboard.includes.swal')
@include('dashboard.includes.helper')

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }

    });
</script>

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/admin/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<!-- END: Page Vendor JS-->


<!-- BEGIN: Page JS-->
<script src="{{ asset('assets/admin/app-assets/js/scripts/forms/form-select2.min.js') }}"></script>
<!-- END: Page JS-->

@vite('resources/js/app.js')



<script>
    $(document).ready(function() {
        $(document).on('submit', 'form', function(event) {
            var submitButton = $(this).find('button[type="submit"], input[type="submit"]');
            submitButton.prop('disabled', true);
            submitButton.html(`{{ __('label.saving') }}`)
        });
    });
</script>

@stack('js')
