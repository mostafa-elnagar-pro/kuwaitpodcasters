<x-dashboard.layout :title="__('label.roles')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.roles') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            {{ __('label.roles') }}
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
                        <h4 class="card-title">{{ __('label.roles') }}</h4>
                        <div class="btns-top">
                            @permission('roles-create')
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>
                                    {{ __('action.add') }}
                                </a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            <table class="datatables-ajax table table-responsive" id="table">
                                <thead class='text-center'>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('label.name') }}</th>
                                        <th>{{ __('label.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class='text-center'>
                                    @foreach ($roles as $role)
                                        <x-dashboard.table.role-item :$role />
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $roles->links() }}
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
