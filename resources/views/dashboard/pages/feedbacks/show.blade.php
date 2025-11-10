<x-dashboard.layout :title="__('label.feedback_details')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.feedbacks') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.feedbacks.index') }}">
                                {{ __('label.feedbacks') }}
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
                    <h4 class="card-title">{{ __('label.feedback_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('feedbacks-delete')
                            <x-dashboard.delete-item :item="$feedback" resource="feedbacks">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $feedback->id }}">
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
                                <td>{{ $feedback->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <td>{{ $feedback->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.email') }}</th>
                                <td>{{ $feedback->email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.phone') }}</th>
                                <td>{{ $feedback->phone }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.description') }}</th>
                                <td>{{ $feedback->message }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($feedback->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
