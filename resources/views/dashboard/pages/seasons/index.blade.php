<x-dashboard.layout :title="__('label.seasons')">

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
                            {{ __('label.seasons') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('label.filter_seasons') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label">{{ __('label.podcasters') }}</label>
                                <select id="podcaster_filter" class="select2 form-select">
                                    <option value="all">{{ __('label.all') }}</option>
                                    @foreach ($podcasters as $podcaster)
                                        <option value="{{ $podcaster->id }}"
                                            data-img="{{ displayFile($podcaster->profile_img) }}">
                                            {{ $podcaster->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <label class="form-label">{{ __('label.channels') }}</label>
                                <select id="channel_filter" class="select2 form-select">
                                    <option value="all">{{ __('label.all') }}</option>
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}"
                                            data-img="{{ displayFile($channel->image) }}">
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ __('label.seasons') }}</h4>
                        <div class="btns-top gap-1">
                            @permission('seasons-delete')
                                <x-dashboard.delete-selected-rows>
                                    <a type="button" class="btn btn-danger waves-effect w-inherit delete_selected d-none"
                                        data-bs-toggle="modal" data-bs-target="#deleteSelectedRows">
                                        <i class="bi bi-trash"></i>
                                        {{ __('action.delete_selected') }}
                                    </a>
                                </x-dashboard.delete-selected-rows>
                            @endpermission
                            @permission('seasons-create')
                                <a href="{{ route('admin.seasons.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>
                                    {{ __('action.add') }}
                                </a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            <form id="bulk_delete_form" action="{{ route('admin.seasons.bulkDelete') }}"
                                method="POST">
                                @csrf
                                @method('DELETE')

                                <table class="datatables-ajax table table-responsive" id="table">
                                    <thead>
                                        <tr>
                                            <th width="1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input check_all" type="checkbox"
                                                        id="inlineCheckbox1" value="checked">
                                                </div>
                                            </th>
                                            <th>#</th>
                                            <th>{{ __('label.the_podcaster') }}</th>
                                            <th>{{ __('label.channel') }}</th>
                                            <th>{{ __('label.name') }}</th>
                                            <th>{{ __('label.podcasts_count') }}</th>
                                            <th>{{ __('label.created_at') }}</th>
                                            <th>{{ __('label.actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('js')
        <x-dashboard.scripts.server-datatable />

        <script>
            $(document).ready(function() {
                const table = loadServerDataTable('.datatables-ajax', "{{ route('admin.seasons.index') }}", [{
                        data: 'checkbox',
                        name: 'checkbox',
                        className: 'avoid-export',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'podcaster',
                        name: 'podcaster'
                    },
                    {
                        data: 'channel',
                        name: 'channel'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'podcasts_count',
                        name: 'podcasts_count'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'avoid-export',
                        orderable: false,
                        searchable: false
                    }
                ], dataFilterCallback);

                const podcasterFilter = $('#podcaster_filter');
                const channelFilter = $('#channel_filter');

                function dataFilterCallback(d) {
                    d.podcaster_id = podcasterFilter.val();
                    d.channel_id = channelFilter.val();
                }

                $("#reset_btn").click(() => {
                    podcasterFilter.val('all').trigger('change');
                    channelFilter.val('all').trigger('change');
                });

                podcasterFilter.change(() => table.draw());
                channelFilter.change(() => table.draw());
            });
        </script>

        <x-dashboard.scripts.select2-img-option id="podcaster_filter" />
        <x-dashboard.scripts.select2-img-option id="channel_filter" />
    @endpush


    </x-dashboard.layout.master>
