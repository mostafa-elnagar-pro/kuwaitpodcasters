<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
<script src="{{ asset('assets/admin/app-assets/vendors/js/tables/datatable/buttons.colVis.min.js') }}"></script>


<script>
    $(document).ready(function() {
        const table = $('.datatables-ajax').DataTable({
            bPaginate: false,
            dom: 'fBrtip',
            stateSave: true,
            buttons: [{
                    extend: 'colvis',
                    className: 'btn btn-dark',
                    text: function(dt) {
                        return "<i class='bi bi-caret-down'></i> {{ __('label.columns') }}";
                    },
                    columnText: function(dt, idx, title) {
                        if (idx === 0) {
                            return "{{ __('label.select_rows') }}";
                        } else if (idx === 1) {
                            return "ID";
                        }
                        return title;
                    }
                }, {
                    extend: 'excel',
                    text: 'EXCEL',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (actions)
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column (actions)
                    }
                }
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/{{ app()->isLocale('en') ? 'English' : 'Arabic' }}.json',
            }
        });
    });
</script>
