<x-dashboard.layout :title="__('label.user_details')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.users') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users.index') }}">
                                {{ __('label.users') }}
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
                    <h4 class="card-title">{{ __('label.user_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('users-update')
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('users-delete')
                            <x-dashboard.delete-item :item="$user" resource="users">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $user->id }}">
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
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.status') }}</th>
                                <td>
                                    @if ($user->status === 'active')
                                        <span class="badge bg-success">{{ __('label.active') }}</span>
                                    @elseif($user->status === 'inactive')
                                        <span class="badge bg-danger">{{ __('label.inactive') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('label.pending') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.type') }}</th>
                                <td>{{ $user->type }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.profile_img') }}</th>
                                <td>
                                    <img src="{{ displayFile($user->profile_img) }}" alt="profile" width="100px" />
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.email') }}</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.phone') }}</th>
                                <td>{{ $user->phone }}</td>
                            </tr>


                            @if ($user->type === 'podcaster')
                                <tr>
                                    <th>{{ __('label.bio') }}</th>
                                    <td>{{ $user->podcasterDetails->bio }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('label.category') }}</th>
                                    <td>{{ $user->podcasterDetails->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('label.social_accounts') }}</th>
                                    <td class="d-flex justify-content-center flex-wrap gap-3">
                                        @foreach (['facebook', 'youtube', 'twitter', 'instagram', 'tiktok', 'snapchat'] as $platform)
                                            @isset($user->podcasterDetails[$platform])
                                                <a href="{{ $user->podcasterDetails[$platform] }}" target="_blank">
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
                                <td>{{ formatDate($user->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
