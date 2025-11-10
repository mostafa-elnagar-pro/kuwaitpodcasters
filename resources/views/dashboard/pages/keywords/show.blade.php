<x-dashboard.layout :title="__('label.keyword_details')">

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
                            <a href="{{ route('admin.keywords.index') }}">
                                {{ __('label.keywords') }}
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
                    <h4 class="card-title">{{ __('label.keyword_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('keywords-update')
                            <a href="{{ route('admin.keywords.edit', $keyword) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('keywords-delete')
                            <x-dashboard.delete-item :item="$keyword" resource="keywords">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $keyword->id }}">
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
                            <tr>
                                <th>#</th>
                                <td>{{ $keyword->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.type') }}</th>
                                <td>{{ $keyword->type }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.key') }}</th>
                                <td>{{ $keyword->key }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.value') }}</th>
                                <td>{{ $keyword->value }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
