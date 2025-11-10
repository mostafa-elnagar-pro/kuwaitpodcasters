<x-dashboard.layout :title="__('label.keywords')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.keywords') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            {{ __('label.keywords') }}
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
                        <h4>{{ __('label.filter_keywords') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <label for="type" class="form-label">{{ __('label.type') }}</label>
                                <x-dashboard.select name="type">
                                    <option value="all">{{ __('label.all') }}</option>
                                    <option value="web">{{ __('label.web') }}</option>
                                    <option value="mobile">{{ __('label.mobile') }}</option>
                                </x-dashboard.select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ __('label.keywords') }}</h4>
                        <div class="btns-top gap-1">
                            @permission('keywords-delete')
                                <x-dashboard.delete-selected-rows>
                                    <a type="button" class="btn btn-danger waves-effect w-inherit delete_selected d-none"
                                        data-bs-toggle="modal" data-bs-target="#deleteSelectedRows">
                                        <i class="bi bi-trash"></i>
                                        {{ __('action.delete_selected') }}
                                    </a>
                                </x-dashboard.delete-selected-rows>
                            @endpermission
                            @permission('keywords-create')
                                <a href="{{ route('admin.keywords.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>
                                    {{ __('action.add') }}
                                </a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            <form id="bulk_delete_form" action="{{ route('admin.keywords.bulkDelete') }}"
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
                                            <th>{{ __('label.type') }}</th>
                                            <th>{{ __('label.key') }}</th>
                                            <th>{{ __('label.value') }}</th>
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
                const table = loadServerDataTable('.datatables-ajax', "{{ route('admin.keywords.index') }}", [{
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
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'key',
                        name: 'key'
                    },
                    {
                        data: 'value',
                        name: 'value'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'avoid-export',
                        orderable: false,
                        searchable: false,
                    }
                ], dataFilterCallback);

                function dataFilterCallback(d) {
                    d.type = $('#type').val();
                }

                $('#type').change(function() {
                    table.draw();
                });
                $('#type').change(function() {
                    table.draw();
                });

            });
        </script>
    @endpush

    </x-dashboard.layout.master>
