<x-dashboard.layout :title="__('label.podcast_details')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.podcasts') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.podcasts.index') }}">
                                {{ __('label.podcasts') }}
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
                    <h4 class="card-title">{{ __('label.podcast_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('podcasts-delete')
                            <x-dashboard.delete-item :item="$podcast" resource="podcasts">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $podcast->id }}">
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
                                <td>{{ $podcast->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.image') }}</th>
                                <td>
                                    <img src="{{ displayFile($podcast->image) }}" alt="image" width="100px" />
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.the_podcaster') }}</th>
                                <td>
                                    <a href="{{ route('admin.podcasters.show', $podcast->podcaster) }}">
                                        {{ $podcast->podcaster->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.channel') }}</th>
                                <td>
                                    <a href="{{ route('admin.channels.show', $podcast->channel) }}">
                                        {{ $podcast->channel->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.season') }}</th>
                                <td>
                                    <a href="{{ route('admin.seasons.show', $podcast->season->id) }}">
                                        {{ $podcast->season->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <td>{{ $podcast->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.description') }}</th>
                                <td>{{ $podcast->description }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.media_type') }}</th>
                                <td>{{ $podcast->media_type }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.media_source') }}</th>
                                <td>{{ $podcast->media_source }}</td>
                            </tr>
                            <tr>
                                <th>{{ __("label.link") }}</th>
                                <td>
                                    @if ($podcast->media_type === 'video')
                                        <video controls width="400px" class="rounded">
                                            <source
                                                src="{{ $podcast->media_source === 'link' ? $podcast->link : displayFile($podcast->link) }}" />
                                        </video>
                                    @else
                                        <audio controls>
                                            <source
                                                src="{{ $podcast->media_source === 'link' ? $podcast->link : displayFile($podcast->link) }}" />
                                        </audio>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($podcast->created_at) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
