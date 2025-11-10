<x-dashboard.layout :title="__('label.season_details')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.seasons') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.seasons.index') }}">
                                {{ __('label.seasons') }}
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
                    <h4 class="card-title">{{ __('label.season_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('seasons-update')
                            <a href="{{ route('admin.seasons.edit', $season) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('seasons-delete')
                            <x-dashboard.delete-item :item="$season" resource="seasons">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $season->id }}">
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
                                <td>{{ $season->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.the_podcaster') }}</th>
                                <td>
                                    <a href="{{ route('admin.podcasters.show', $season->channel->owner) }}">
                                        {{ $season->channel->owner->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.channel') }}</th>
                                <td>
                                    <a href="{{ route('admin.channels.show', $season->channel) }}">
                                        {{ $season->channel->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <td>{{ $season->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.podcasts_count') }}</th>
                                <td>{{ $season->podcasts_count }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($season->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
