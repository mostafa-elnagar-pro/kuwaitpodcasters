<x-dashboard.layout :title="__('label.podcasts')">

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
                            {{ __('label.podcasts') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <section id="ajax-datatable">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('label.filter_podcasts') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mt-1">
                            <label class="form-label">{{ __('label.categories') }}</label>
                            <select id="category_filter" class="select2 form-select">
                                <option value="all">{{ __('label.all') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" data-img="{{ displayFile($category->image) }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-1">
                            <label class="form-label">{{ __('label.podcasters') }}</label>
                            <select id="podcaster_filter" class="select2 form-select">
                                <option value="all">{{ __('label.all') }}</option>
                                @foreach ($podcasters as $podcaster)
                                    <option value="{{ $podcaster->id }}"
                                        data-img="{{ displayFile($podcaster->profile_img) }}">
                                        {{ $podcaster->name . ' (' . $podcaster->email . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="channel_filter col-md-6 mt-1 d-none">
                            <label class="form-label">{{ __('label.channels') }}</label>
                            <select id="channel_filter" class="select2 form-select">
                                <!-- options injected by ajax -->
                            </select>
                        </div>

                        <div class="season_filter col-md-6 mt-1 d-none">
                            <label class="form-label">{{ __('label.seasons') }}</label>
                            <select id="season_filter" class="select2 form-select">
                                <!-- options injected by ajax -->
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('label.podcasts') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('podcasts-delete')
                            <x-dashboard.delete-selected-rows>
                                <a type="button" class="btn btn-danger waves-effect w-inherit delete_selected d-none"
                                    data-bs-toggle="modal" data-bs-target="#deleteSelectedRows">
                                    <i class="bi bi-trash"></i>
                                    {{ __('action.delete_selected') }}
                                </a>
                            </x-dashboard.delete-selected-rows>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-datatable">
                        <form id="bulk_delete_form" action="{{ route('admin.podcasts.bulkDelete') }}" method="POST">
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
                                        <th>{{ __('label.season') }}</th>
                                        <th>{{ __('label.image') }}</th>
                                        <th>{{ __('label.name') }}</th>
                                        <th>{{ __('label.media_type') }}</th>
                                        <th>{{ __('label.media_source') }}</th>
                                        <th>{{ __('label.status') }}</th>
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
    </section>


    @push('js')
        <x-dashboard.scripts.server-datatable />

        <script>
            $(document).ready(function() {
                const table = loadServerDataTable('.datatables-ajax', "{{ route('admin.podcasts.index') }}", [{
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
                        data: 'season',
                        name: 'season'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        className: 'avoid-export',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'media_type',
                        name: 'media_type'
                    },
                    {
                        data: 'media_source',
                        name: 'media_source',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'avoid-export',
                        orderable: false,
                        searchable: false
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

                const categoryFilter = $('#category_filter');
                const podcasterFilter = $('#podcaster_filter');
                const channelFilter = $('#channel_filter');
                const seasonFilter = $('#season_filter');

                function dataFilterCallback(d) {
                    d.category_id = categoryFilter.val();
                    d.podcaster_id = podcasterFilter.val();
                    d.channel_id = channelFilter.val();
                    d.season_id = seasonFilter.val();
                }

                podcasterFilter.change(function() {
                    const podcasterId = $(this).val();

                    channelFilter.empty().trigger('change');
                    seasonFilter.empty().trigger('change');

                    if (podcasterId === 'all') {
                        $('.channel_filter').addClass('d-none');
                        $('.season_filter').addClass('d-none');
                    } else {
                        $.ajax({
                            url: "{{ route('admin.channel.seasons') }}",
                            type: 'GET',
                            data: {
                                podcaster_id: podcasterId
                            },
                            success: function(response) {
                                $('.col-md-6.d-none').removeClass('d-none');

                                channelFilter.html(response.channel_options);
                                seasonFilter.html(response.season_options);

                                channelFilter.trigger('change');
                                seasonFilter.trigger('change');
                            },
                        });
                    }

                    table.draw();
                });

                seasonFilter.change(() => table.draw());
                categoryFilter.change(() => table.draw());
            });
        </script>

        <x-dashboard.scripts.select2-img-option id="category_filter" />
        <x-dashboard.scripts.select2-img-option id="podcaster_filter" />
        <x-dashboard.scripts.select2-img-option id="channel_filter" />
    @endpush
    </x-dashboard.layout.master>
