<script>
    /*
     * submit form using axios
     *  */

    $('.form').on('submit', function(event) {
        event.preventDefault();
        let e = this;
        $(e).find($('button[type="submit"]')).append(' <i class="fa fa-spinner fa-spin"><i>');
        let url = $(e).attr('action');
        let data = new FormData($(e)[0]);

        function callBackFunction(response) {
            $('.errors').remove();
            $('.is-invalid').removeClass('is-invalid');
            $(e).find($('button[type="submit"]')).find('i').remove()
            if (response.status == 200) {
                window.location = '/' + response.data.data.redirect_url;
            } else if (response.status == 422) {
                formErrors(response);
            } else {
                sweetAlert('error', response.data.errors)
            }
        }

        AxiosPost(url, data, callBackFunction)
    })

    // fire form errors
    function formErrors(response) {
        $.each(response.data.errors, function(key, val) {
            sweetAlert('error', val)

            let error_input = $(`input[name='${key}'], textarea[name='${key}'], select[name='${key}']`);
            if (error_input) {
                error_input.addClass('is-invalid')
                error_input.parent().append(`<p class="errors text-danger"> <span>${val}</span></p>`)
            }

        })
    }

    // change status
    $(document).on('change', '.status', function() {
        let id = $(this).data('id');
        let url = $(this).data('url');
        AxiosUpdate(url, {
            'id': id
        })
    })

    // check all

    $(document).on('click', '.check_all', function() {
        if ($(this).is(':checked')) {
            $('.items').prop('checked', true);
            $('.items:checked').length ? $('.delete_selected').removeClass('d-none') : '';
        } else {
            $('.items').prop('checked', false);
            $('.delete_selected').addClass('d-none')
        }
    })

    // when check one item
    $(document).on('click', '.items', function() {
        if ($(this).is(':checked') && $('.items:checked').length > 0) {
            $('.delete_selected').removeClass('d-none');
            $('.items:checked').length == $('.items').length ? $('.check_all').prop('checked', true) : $(
                '.check_all').prop('checked', false)
        } else {
            $('.items:checked').length > 0 ? $('.delete_selected').removeClass('d-none') : $('.delete_selected')
                .addClass('d-none');
            $('.check_all').prop('checked', false);
        }
    });

    // delete selected items
    // $('.delete_selected').on('click', function() {
    //     if ($('.items:checked').length > 0) {
    //         Swal.fire({
    //             title: "{{ __('label.confirm_delete') }}",
    //             text: "{{ __('messages.confirmDelete') }}",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonText: "{{ __('action.confirm') }}",
    //             cancelButtonText: "{{ __('action.cancel') }}",
    //             customClass: {
    //                 confirmButton: 'btn btn-primary',
    //                 cancelButton: 'btn btn-outline-danger ms-1'
    //             },
    //             buttonsStyling: false
    //         }).then(function(result) {
    //             if (result.value) {
    //                 console.log("EE")
    //                 let bulk_delete_form = $('#bulk_delete_form');
    //                 let url = bulk_delete_form.attr('action');
    //                 let data = new FormData($(bulk_delete_form)[0]);

    //                 function callBackFunction(response) {
    //                     $('.delete_selected').addClass('d-none');

    //                     if (response.status == 200) {
    //                         sweetAlert(response.data.status, response.data.message)
    //                         // $('.table').DataTable().draw(false);
    //                         $('.items:checked').closest('tr').hide()
    //                         $('.items:checked').prop('checked', false)
    //                         $('.check_all').prop('checked', false)
    //                     } else {
    //                         toastr.error("{{ __('messages.error') }}");
    //                     }
    //                 }

    //                 AxiosBulkDelete(url, data, callBackFunction);
    //             }
    //         });
    //     }
    // });

    // delete one item
    // $(document).on('click', '.delete_raw', function() {
    //     let form = $(this).parent('#delete_form');
    //     let id = $(this).data('id');
    //     let url = $(this).data('url')

    //     Swal.fire({
    //         title: '{{ __('app.Are you sure?') }}',
    //         text: "{{ __('app.field could be related to other data') }}",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: '{{ __('app.Yes, delete it!') }}',
    //         cancelButtonText: "{{ __('app.cancel') }}",
    //         customClass: {
    //             confirmButton: 'btn btn-primary',
    //             cancelButton: 'btn btn-outline-danger ms-1'
    //         },
    //         buttonsStyling: false
    //     }).then(function(result) {
    //         if (result.value) {
    //             function callBackFunction(response) {
    //                 if (response.status == 200) {
    //                     $('#table').load(`${document.URL} #table`);
    //                     sweetAlert(response.data.status, response.data.message)
    //                 }

    //             }

    //             AxiosDeleteItem(url, id, callBackFunction);
    //         }

    //     })
    // });





    // function renderSweetAlert(datatable, id, url, shouldRefresh = false) {
    //     Swal.fire({
    //         title: '{{ __('app.Are you sure?') }}',
    //         text: "{{ __('app.field could be related to other data') }}",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: '{{ __('app.Yes, delete it!') }}',
    //         cancelButtonText: "{{ __('app.cancel') }}",
    //         customClass: {
    //             confirmButton: 'btn btn-primary',
    //             cancelButton: 'btn btn-outline-danger ms-1'
    //         },
    //         buttonsStyling: false
    //     }).then(function(result) {
    //         if (result.value) {
    //             function callBackFunction(response) {
    //                 if (response.status == 200) {
    //                     if (shouldRefresh) {
    //                         location.reload()
    //                     } else {
    //                         datatable.row($(this).closest('tr')).remove().draw(false);
    //                     }
    //                     sweetAlert(response.data.status, response.data.message)
    //                 }

    //             }

    //             AxiosDeleteItem(url, id, callBackFunction);
    //         }
    //     })
    // }



    // image preview
    $('.image').on('change', function(e) {
        let file = e.target.files[0],
            url = URL.createObjectURL(file);
        $(this).parents('.parent').find('.preview').attr('src', url);
    });
</script>

<script>
    function progress() {
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        $('form').ajaxForm({
            beforeSend: function() {

            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            complete: function(xhr) {
                status.html(xhr.responseText);
            }
        });
    }
</script>
