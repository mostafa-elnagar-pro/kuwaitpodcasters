<x-dashboard.layout :title="__('label.app_rates')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.app_rates') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            {{ __('label.app_rates') }}
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
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ __('label.app_rates') }}</h4>
                        <div class="btns-top gap-1">
                            @permission('app_rates-delete')
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
                            <form id="bulk_delete_form" action="{{ route('admin.app_rates.bulkDelete') }}"
                                method="POST">
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
                                            <th>{{ __('label.email') }}</th>
                                            <th>{{ __('label.rate') }}</th>
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
                loadServerDataTable('.datatables-ajax', "{{ route('admin.app_rates.index') }}", [{
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'value',
                        name: 'value'
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

    </x-dashboard.layout.master>
