<x-dashboard.layout :title="__('label.view')">

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
                            <a href="{{ route('admin.languages.index') }}">
                                {{ __('label.languages') }}
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
                        @permission('languages-update')
                            <a href="{{ route('admin.languages.edit', $language) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('languages-delete')
                            <x-dashboard.delete-item :item="$language" resource="languages">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $language->id }}">
                                    <i class="fa fa-trash"></i>
                                    {{ __('action.delete') }}
                                </button>
                            </x-dashboard.delete-item>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-datatable">
                        <table class="table table-responsive text-center" id="table">
                            <x-dashboard.table.language-item :$language :horizontal="false" />
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
