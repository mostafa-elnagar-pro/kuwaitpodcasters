<x-dashboard.layout :title="__('label.users')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.users') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            {{ __('label.users') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('label.filter_users') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <label for="status" class="form-label">{{ __('label.status') }}</label>
                                <x-dashboard.select name="status">
                                    <option value="all">{{ __('label.all') }}</option>
                                    <option value="active">{{ __('label.active') }}</option>
                                    <option value="inactive">{{ __('label.inactive') }}</option>
                                    <option value="pending">{{ __('label.pending') }}</option>
                                </x-dashboard.select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ __('label.users') }}</h4>
                        <div class="btns-top gap-1">
                            @permission('users-delete')
                                <x-dashboard.delete-selected-rows>
                                    <a type="button" class="btn btn-danger waves-effect w-inherit delete_selected d-none"
                                        data-bs-toggle="modal" data-bs-target="#deleteSelectedRows">
                                        <i class="bi bi-trash"></i>
                                        {{ __('action.delete_selected') }}
                                    </a>
                                </x-dashboard.delete-selected-rows>
                            @endpermission
                            @permission('users-update')
                                <x-dashboard.notify-all type="user">
                                    <a type="button" class="btn btn-blue waves-effect w-inherit" data-bs-toggle="modal"
                                        data-bs-target="#notifyAll">
                                        <i class="bi bi-bell"></i>
                                        {{ __('action.notify_all') }}
                                    </a>
                                </x-dashboard.notify-all>
                            @endpermission
                            @permission('users-create')
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>
                                    {{ __('action.add') }}
                                </a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            <form id="bulk_delete_form" action="{{ route('admin.users.bulkDelete') }}" method="POST">
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
                                            <th>{{ __('label.status') }}</th>
                                            <th>{{ __('label.profile_img') }}</th>
                                            <th>{{ __('label.name') }}</th>
                                            <th>{{ __('label.type') }}</th>
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
                const table = loadServerDataTable('.datatables-ajax', "{{ route('admin.users.index') }}", [{
                        data: 'checkbox',
                        name: 'checkbox',
                        className: 'avoid-export',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'profile_img',
                        name: 'profile_img',
                        className: 'avoid-export',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'type',
                        name: 'type',
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        visible: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'avoid-export',
                        searchable: false,
                        orderable: false,
                    }
                ], dataFilterCallback);

                function dataFilterCallback(d) {
                    d.user_type = $('#user_type').val();
                    d.status = $('#status').val();
                }

                $("#reset_btn").click(function() {
                    $('#user_type').val('all').trigger('change');
                    $('#status').val('all').trigger('change');
                })

                $('#user_type').change(function() {
                    table.draw();
                });
                $('#status').change(function() {
                    table.draw();
                });

            });
        </script>
    @endpush

    </x-dashboard.layout.master>
