<x-dashboard.layout :title="__('label.exclusive_episode_details')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.exclusive_episodes') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.exclusive-episodes.index') }}">
                                {{ __('label.exclusive_episodes') }}
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
                    <h4 class="card-title">{{ __('label.exclusive_episode_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('exclusive-episodes-update')
                            <a href="{{ route('admin.exclusive-episodes.edit', $episode) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('exclusive-episodes-delete')
                            <x-dashboard.delete-item :item="$episode" resource="exclusive-episodes">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $episode->id }}">
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
                                <td>{{ $episode->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.image') }}</th>
                                <td>
                                    <img src="{{ displayFile($episode->image) }}" alt="image" width="100px" />
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.the_podcaster') }}</th>
                                <td>
                                    <a href="{{ route('admin.podcasters.show', $episode->podcaster) }}">
                                        {{ $episode->podcaster->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.channel') }}</th>
                                <td>
                                    <a href="{{ route('admin.channels.show', $episode->channel) }}">
                                        {{ $episode->channel->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.season') }}</th>
                                <td>
                                    <a href="{{ route('admin.seasons.show', $episode->season->id) }}">
                                        {{ $episode->season->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <td>{{ $episode->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.description') }}</th>
                                <td>{{ $episode->description }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.media_type') }}</th>
                                <td>{{ $episode->media_type }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.media_source') }}</th>
                                <td>{{ $episode->media_source }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.link') }}</th>
                                <td>
                                    @if ($episode->media_type === 'video')
                                        <video controls width="400px" class="rounded">
                                            <source
                                                src="{{ $episode->media_source === 'link' ? $episode->link : displayFile($episode->link) }}" />
                                        </video>
                                    @else
                                        <audio controls>
                                            <source
                                                src="{{ $episode->media_source === 'link' ? $episode->link : displayFile($episode->link) }}" />
                                        </audio>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($episode->created_at) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>

