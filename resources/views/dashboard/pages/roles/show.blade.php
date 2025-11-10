<x-dashboard.layout :title="__('label.view')">

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
                            <a href="{{ route('admin.roles.index') }}">
                                {{ __('label.roles') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.view') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('label.view') }}</h4>
                    <div class="btns-top gap-1">
                        @if ($role->name !== 'admin')
                            @permission('roles-update')
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-success">
                                    <i class="fa fa-pencil"></i>
                                    {{ __('action.edit') }}
                                </a>
                            @endpermission
                            @permission('roles-delete')
                                <x-dashboard.delete-item :item="$role" resource="roles">
                                    <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                        data-bs-target="#deleteRecord{{ $role->id }}">
                                        <i class="fa fa-trash"></i>
                                        {{ __('action.delete') }}
                                    </button>
                                </x-dashboard.delete-item>
                            @endpermission
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-datatable">
                        <table class="table table-responsive text-center" id="table">
                            <x-dashboard.table.role-item :$role :horizontal="false" />
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
