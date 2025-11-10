<x-dashboard.layout :title="__('label.podcaster_details')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.podcasters') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.podcasters.index') }}">
                                {{ __('label.podcasters') }}
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
            <h4>{{ __('label.podcaster_stats') }}</h4>
        </div>
        <div class="row">
            <x-dashboard.widget label="seasons" :value="$podcaster->channel->seasons_count ?? 0" icon="calendar" />
            <x-dashboard.widget label="podcasts" :value="$podcaster->podcasts_count" icon="headphones" />
            <x-dashboard.widget label="videos" :value="$podcaster->videos_count" icon="film" />
            <x-dashboard.widget label="audios" :value="$podcaster->audios_count" icon="music-note" />
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('label.podcaster_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('podcasters-update')
                            <a href="{{ route('admin.podcasters.edit', $podcaster) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('podcasters-delete')
                            <x-dashboard.delete-item :item="$podcaster" resource="podcasters">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $podcaster->id }}">
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
                                <td>{{ $podcaster->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.status') }}</th>
                                <td>
                                    @if ($podcaster->status === 'active')
                                        <span class="badge bg-success">{{ __('label.active') }}</span>
                                    @elseif($podcaster->status === 'inactive')
                                        <span class="badge bg-danger">{{ __('label.inactive') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('label.pending') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.type') }}</th>
                                <td>{{ __("label.$podcaster->type") }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.profile_img') }}</th>
                                <td>
                                    <img src="{{ displayFile($podcaster->profile_img) }}" alt="profile"
                                        width="100px" />
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <td>{{ $podcaster->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.email') }}</th>
                                <td>{{ $podcaster->email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.phone') }}</th>
                                <td>{{ $podcaster->phone }}</td>
                            </tr>


                            @if ($podcaster->type === 'podcaster')
                                <tr>
                                    <th>{{ __('label.bio') }}</th>
                                    <td>{{ $podcaster->podcasterDetails->bio }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('label.category') }}</th>
                                    <td>{{ $podcaster->podcasterDetails->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('label.social_accounts') }}</th>
                                    <td class="d-flex justify-content-center flex-wrap gap-3">
                                        @foreach (['facebook', 'youtube', 'twitter', 'instagram', 'tiktok', 'snapchat', 'linkedin'] as $platform)
                                            @isset($podcaster->podcasterDetails[$platform])
                                                <a href="{{ $podcaster->podcasterDetails[$platform] }}" target="_blank">
                                                    <img src="{{ asset("assets/images/social/$platform.svg") }}"
                                                        alt="{{ $platform }}" width="30px" />
                                                </a>
                                            @endisset
                                        @endforeach
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($podcaster->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
