<x-dashboard.layout :title="__('label.channel_details')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.channels') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.channels.index') }}">
                                {{ __('label.channels') }}
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
        <div class="card-header">
            <h4>{{ __('label.channel_stats') }}</h4>
        </div>
        <div class="row">
            <x-dashboard.widget label="seasons" :value="$channel->seasons_count" icon="calendar" />
            <x-dashboard.widget label="podcasts" :value="$channel->podcasts_count" icon="headphones" />
            <x-dashboard.widget label="videos" :value="$channel->videos_count" icon="film" />
            <x-dashboard.widget label="audios" :value="$channel->audios_count" icon="music-note" />
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('label.channel_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('channels-update')
                            <a href="{{ route('admin.channels.edit', $channel) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('channels-delete')
                            <x-dashboard.delete-item :item="$channel" resource="channels">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $channel->id }}">
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
                                <td>{{ $channel->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.image') }}</th>
                                <td>
                                    <img src="{{ displayFile($channel->image) }}" alt="image" width="100px" />
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.owner') }}</th>
                                <td>
                                    <a href="{{ route('admin.podcasters.show', $channel->owner->id) }}">
                                        {{ $channel->owner->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <td>{{ $channel->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.description') }}</th>
                                <td>{{ $channel->description }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($channel->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

    </x-dashboard.layout.master>
