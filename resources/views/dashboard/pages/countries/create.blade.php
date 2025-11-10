@php
    $countries = collect(config('countries'))->whereNotIn('flag', $existingCountryFlags);
@endphp

<x-dashboard.layout :title="__('label.new_country')">

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
                            {{ __('label.new_country') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_country') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.countries.store') }}" enctype="multipart/form-data">

                @csrf

                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="name">
                                    {{ __('label.name') }}
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="{{ __('label.name') }}" />
                            </div>
                        </div> --}}

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label for="flag" class="form-label">
                                    {{ __('label.select_countries') }}
                                </label>
                                <select id="select2WithOptionIcon" name="countries[]" class="select2 form-select"
                                    multiple>
                                    @foreach ($countries as $country)
                                        <option value="{{ json_encode($country) }}"
                                            data-icon="flag-icon-{{ $country['flag'] }}">
                                            {{ $country['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="code">
                                    {{ __('label.code') }}
                                </label>
                                <input type="text" id="code" name="code" value="{{ old('code') }}"
                                    class="form-control" placeholder="{{ __('label.code') }}" />
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="digits_count">
                                    {{ __('label.digits_count') }}
                                </label>
                                <input type="number" id="digits_count" name="digits_count"
                                    value="{{ old('digits_count') }}" class="form-control"
                                    placeholder="{{ __('label.digits_count') }}" />
                            </div>
                        </div> --}}

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
        <x-dashboard.scripts.select2-icon-option />
    @endpush

    </x-dashboard.layout.master>
