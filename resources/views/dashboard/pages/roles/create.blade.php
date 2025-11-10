<x-dashboard.layout :title="__('label.new_role')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.roles') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.roles.index') }}">
                                {{ __('label.roles') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_role') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_role') }}</h4>
            </div>
            <form action="{{ route('admin.roles.store') }}" method="POST">

                @csrf

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="name">
                                    {{ __('label.name') }}
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="{{ __('label.name') }}" />
                            </div>
                        </div>


                        <div class="mt-3 col-12 d-flex flex-column">
                            <div class="col-md-12 mb-1">
                                <div class="form-check form-check-success form-switch">
                                    <input type="checkbox" class="form-check-input check_all" id="customSwitch4">
                                    <label class="form-check-label mb-50"
                                        for="customSwitch4">{{ __('label.all') }}</label>
                                </div>
                            </div>

                            <ul class="list-permissions">
                                @foreach ($permissionList as $group => $permissions)
                                    <li class="{{ $group }}" id="{{ $group }}">
                                        <h4>{{ __("label.$group") }}</h4>
                                        <div class="roles-check">
                                            @foreach ($permissions as $permission)
                                                <label class="switch" for="{{ $permission->id }}">
                                                    <p>
                                                        {{ __("label.$permission->name") . ' ' . __("label.$permission->group") }}
                                                    </p>
                                                    <input type="checkbox" class="items" value="{{ $permission->id }}"
                                                        name="permissions[]" id="{{ $permission->id }}">
                                                </label>
                                            @endforeach
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
                        {{ __('action.save') }}
                    </button>
                </div>
            </form>
        </div>
    </section>


    @push('js')
        <script>
            if ($(".items:checked").length == $(".items").length) {
                $('.check_all').prop('checked', true)
            }
        </script>
    @endpush

    </x-dashboard.layout.master>
