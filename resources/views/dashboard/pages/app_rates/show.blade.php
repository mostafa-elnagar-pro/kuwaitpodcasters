<x-dashboard.layout :title="__('label.rate_details')">

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
                            <a href="{{ route('admin.app_rates.index') }}">
                                {{ __('label.app_rates') }}
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
                    <h4 class="card-title">{{ __('label.rate_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('app_rates-delete')
                            <x-dashboard.delete-item :item="$app_rate" resource="app_rates">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $app_rate->id }}">
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
                                <td>{{ $app_rate->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.user') }}</th>
                                <td>
                                    <a href="{{ route("admin.{$app_rate->user->type}s.show", $app_rate->user) }}">
                                        {{ $app_rate->user->email }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.rate') }}</th>
                                <td>{{ $app_rate->value }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.message') }}</th>
                                <td>{{ $app_rate->message }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($app_rate->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
