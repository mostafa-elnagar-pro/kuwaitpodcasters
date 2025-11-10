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
    function getBase64ImageFromUrl(imageUrl, callback) {
        var img = new Image();
        img.setAttribute('crossOrigin', 'anonymous'); // For cross-origin image loading
        img.onload = function() {
            var canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);
            var dataURL = canvas.toDataURL("image/png");
            callback(dataURL);
        };
        img.src = imageUrl;
    }


    function loadServerDataTable(selector, ajaxUrl, columnsConfig, dataFilter = null, searchDelay = 700) {
        pdfMake.fonts = {
            Bahij: {
                normal: 'Bahij_Plain.ttf',
                bold: 'Bahij_Plain.ttf',
            }
        };

        return $(selector).DataTable({
            searchDelay,
            processing: true,
            serverSide: true,
            stateSave: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            ajax: {
                url: ajaxUrl,
                type: 'GET',
                data: function(d) {
                    if (dataFilter !== null) {
                        dataFilter(d);
                    }
                },
                error: function(xhr, error, code) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('admin.login.show') }}";
                    } else {
                        console.error('An error occurred:', error);
                    }
                }
            },
            columns: columnsConfig,
            order: [
                [1, 'desc']
            ],
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
                        columns: function(idx, data, node) {
                            const isVisible = $(node).is(':visible');
                            const isExcluded = $(node).hasClass('avoid-export')

                            return isVisible && !isExcluded;
                        }
                    },
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: function(idx, data, node) {
                            const isVisible = $(node).is(':visible');
                            const isExcluded = $(node).hasClass('avoid-export')

                            return isVisible && !isExcluded;
                        }
                    },
                    customize: function(doc) {
                        doc.defaultStyle.font = 'Bahij';
                        doc.defaultStyle.alignment = 'right';
                        doc.content.forEach(function(item) {
                            if (item.table) {
                                item.table.body.forEach(function(row) {
                                    row.forEach(function(cell) {
                                        cell.alignment = 'right';
                                        cell.text = cell.text.split(" ")
                                            .reverse().join(" ");
                                    });
                                });
                            }
                        });
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: function(idx, data, node) {
                            const isVisible = $(node).is(':visible');
                            const isExcluded = $(node).hasClass('avoid-export')

                            return isVisible && !isExcluded;
                        }
                    },
                    customize: function(csv) {
                        return '\ufeff' + csv;
                    }
                },
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/{{ app()->isLocale('en') ? 'English' : 'Arabic' }}.json',
            },
            dom: 'Bfrltip',
        });
    }
</script>
