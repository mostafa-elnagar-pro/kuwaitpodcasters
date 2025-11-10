<x-dashboard.layout :title="__('label.category_details')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.categories') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.categories.index') }}">
                                {{ __('label.categories') }}
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
                    <h4 class="card-title">{{ __('label.category_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('categories-update')
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('categories-delete')
                            <x-dashboard.delete-item :item="$category" resource="categories">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $category->id }}">
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
                                <td>{{ $category->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.image') }}</th>
                                <td>
                                    <img src="{{ displayFile($category->image) }}" alt="image" width="100px"
                                        class="rounded" />
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.status') }}</th>
                                <td>
                                   {{ $category->is_active  ? __('label.active') : __('label.inactive')}}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <td>{{ $category->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($category->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
