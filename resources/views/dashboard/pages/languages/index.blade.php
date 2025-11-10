<x-dashboard.layout :title="__('label.languages')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.languages') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            {{ __('label.languages') }}
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
                        <h4 class="card-title">{{ __('label.languages') }}</h4>
                        <div class="btns-top gap-1">
                            @permission('languages-delete')
                                <x-dashboard.delete-selected-rows>
                                    <a type="button" class="btn btn-danger waves-effect w-inherit delete_selected d-none"
                                        data-bs-toggle="modal" data-bs-target="#deleteSelectedRows">
                                        <i class="bi bi-trash"></i>
                                        {{ __('action.delete_selected') }}
                                    </a>
                                </x-dashboard.delete-selected-rows>
                            @endpermission
                            @permission('languages-create')
                                <a href="{{ route('admin.languages.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i>
                                    {{ __('action.add') }}
                                </a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            <form id="bulk_delete_form" action="{{ route('admin.languages.bulkDelete') }}"
                                method="POST">
                                @csrf
                                @method('DELETE')

                                <table class="datatables-ajax table table-responsive" id="table">
                                    <thead class="text-center">
                                        <tr>
                                            <th width="1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input check_all" type="checkbox"
                                                        id="inlineCheckbox1" value="checked">
                                                </div>
                                            </th>
                                            <th>#</th>
                                            <th>{{ __('label.flag') }}</th>
                                            <th>{{ __('label.name') }}</th>
                                            <th>{{ __('label.abbr') }}</th>
                                            <th>{{ __('label.direction') }}</th>
                                            <th>{{ __('label.status') }}</th>
                                            <th>{{ __('label.created_at') }}</th>
                                            <th>{{ __('label.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($languages as $language)
                                            <x-dashboard.table.language-item :$language />
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>

                            {{ $languages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            $(document).ready(function() {
                const table = $('.datatables-ajax').DataTable({
                    bPaginate: false,
                    info: false,
                    dom: 'fBrtip',
                });
            });
        </script>
    @endpush

    </x-dashboard.layout.master>
