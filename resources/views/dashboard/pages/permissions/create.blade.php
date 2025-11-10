<x-dashboard.layout :title="__('label.new_permission')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.permissions') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.permissions.index') }}">
                                {{ __('label.permissions') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_permission') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_permission') }}</h4>
            </div>
            <form action="{{ route('admin.permissions.store') }}" method="POST">

                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="group">
                                    {{ __('label.group') }}
                                </label>
                                <input type="text" id="group" name="group" value="{{ old('group') }}"
                                    class="form-control" placeholder="{{ __('label.group') }}" />
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group d-flex flex-column gap-1">
                                <label class="form-label">
                                    {{ __('label.options') }}
                                </label>
                                <div class="mb-1 d-flex flex-column gap-2">
                                    @foreach (['create', 'read', 'update', 'delete'] as $option)
                                        <div class="form-check">
                                            <input type="checkbox" id="{{ $option }}" name="options[]"
                                                value="{{ $option }}" class="form-check-input"
                                                @checked(in_array($option, old('permissions', []))) />
                                            <label class="form-check-label" for="{{ $option }}">
                                                {{ ucfirst($option) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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

    </x-dashboard.layout.master>
