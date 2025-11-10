<x-dashboard.layout :title="__('label.edit_country')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.countries') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.countries.index') }}">
                                {{ __('label.countries') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.edit_country') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.edit_country') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.countries.update', $country) }}" enctype="multipart/form-data">

                @csrf

                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="name">
                                    {{ __('label.name') }}
                                </label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $country->name) }}" class="form-control"
                                    placeholder="{{ __('label.name') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12 d-flex align-items-center parent">
                            <div class="mb-2 flex-grow-1">
                                <label for="flag" class="form-label">
                                    {{ __('label.flag') }}
                                </label>
                                <input type="file" id="flag" name="flag" class="form-control image"
                                    accept=".jpg,.jpeg,.png,.svg">
                            </div>
                            <img src="{{ displayFile($country->flag) }}" id="preview_img" class="preview rounded" />
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="code">
                                    {{ __('label.code') }}
                                </label>
                                <input type="text" id="code" name="code"
                                    value="{{ old('code', $country->code) }}" class="form-control"
                                    placeholder="{{ __('label.code') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="digits_count">
                                    {{ __('label.digits_count') }}
                                </label>
                                <input type="text" id="digits_count" name="digits_count"
                                    value="{{ old('digits_count', $country->digits_count) }}" class="form-control"
                                    placeholder="{{ __('label.digits_count') }}" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
                        {{ __('action.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    </x-dashboard.layout.master>
