<x-dashboard.layout :title="__('label.admins')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.admins') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            {{ __('label.admins') }}
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
                        <h4 class="card-title">{{ __('label.admins') }}</h4>
                        <div class="btns-top">
                            @permission('admins-delete')
                                {{--                        <a class="btn btn-danger delete_selected d-none"><i class="fa fa-trash"></i> Delete Selected</a> --}}
                            @endpermission
                            @permission('admins-create')
                                <a href="{{ route('admin.admins.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i>
                                    {{ __('action.add') }}
                                </a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            <table class="datatables-ajax table table-responsive" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('label.name') }}</th>
                                        <th>{{ __('label.email') }}</th>
                                        <th>{{ __('label.created_at') }}</th>
                                        <th>{{ __('label.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <x-dashboard.table.admin-item :$admin />
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $admins->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <x-dashboard.scripts.client-datatable />
    @endpush

    </x-dashboard.layout.master>
