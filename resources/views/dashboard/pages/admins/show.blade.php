<x-dashboard.layout :title="__('label.admin_details')">

    @permission('admins-read')
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
                                <a href="{{ route('admin.admins.index') }}">
                                    {{ __('label.admins') }}
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
    @endpermission

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('label.admin_details') }}</h4>
                    <div class="btns-top gap-1">
                        @if ($admin->id !== 1)
                            @permission('admins-update')
                                <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-success">
                                    <i class="fa fa-pencil"></i>
                                    {{ __('action.edit') }}
                                </a>
                            @endpermission
                            @permission('admins-delete')
                                <x-dashboard.delete-item :item="$admin" resource="admins">
                                    <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                        data-bs-target="#deleteRecord{{ $admin->id }}">
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
                        {{-- <form id="delete_form" action="{{ route('admin.admins.destroy', $admin) }}" method="post"> --}}
                        {{-- @csrf --}}

                        <table class="table table-responsive text-center" id="table">
                            <x-dashboard.table.admin-item :$admin :horizontal="false" />
                        </table>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
