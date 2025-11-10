<section id="ajax-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('label.feedbacks') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('feedbacks-delete')
                            <x-dashboard.delete-selected-rows>
                                <a type="button" class="btn btn-danger waves-effect w-inherit delete_selected d-none"
                                    data-bs-toggle="modal" data-bs-target="#deleteSelectedRows">
                                    <i class="bi bi-trash"></i>
                                    {{ __('action.delete_selected') }}
                                </a>
                            </x-dashboard.delete-selected-rows>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-datatable">
                        <form id="bulk_delete_form" action="{{ route('admin.feedbacks.bulkDelete') }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <table class="datatables-ajax table table-responsive" id="table">
                                <thead>
                                    <tr>
                                        <th width="1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input check_all" type="checkbox"
                                                    id="inlineCheckbox1" value="checked">
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>{{ __('label.name') }}</th>
                                        <th>{{ __('label.email') }}</th>
                                        <th>{{ __('label.phone') }}</th>
                                        <th>{{ __('label.created_at') }}</th>
                                        <th>{{ __('label.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@push('js')
    <x-dashboard.scripts.server-datatable />

    <script>
        $(document).ready(function() {
            loadServerDataTable('.datatables-ajax', "{{ route('admin.feedbacks.index') }}", [{
                    data: 'checkbox',
                    name: 'checkbox',
                    className: 'avoid-export',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    className: 'avoid-export',
                    orderable: false,
                    searchable: false
                }
            ]);
        });
    </script>
@endpush
