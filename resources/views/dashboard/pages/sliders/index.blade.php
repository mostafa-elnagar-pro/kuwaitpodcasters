<x-dashboard.layout :title="__('label.sliders')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.sliders') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            {{ __('label.sliders') }}
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
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ __('label.sliders') }}</h4>
                        <div class="btns-top">
                            @permission('sliders-delete')
                                {{--                        <a class="btn btn-danger delete_selected d-none"><i class="fa fa-trash"></i> Delete Selected</a> --}}
                            @endpermission
                            @permission('sliders-create')
                                <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary"><i
                                        class="fa fa-plus"></i>
                                    {{ __('action.add') }}
                                </a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            <table class="datatables-ajax table table-responsive" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('label.image') }}</th>
                                        <th>{{ __('label.created_at') }}</th>
                                        <th>{{ __('label.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slider)
                                        <x-dashboard.table.slider-item :$slider />
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $sliders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <x-dashboard.scripts.client-datatable />
    @endpush

    </x-dashboard.layout.master>
