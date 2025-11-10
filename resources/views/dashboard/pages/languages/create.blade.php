@php
    $langs = collect(config('langs'))->whereNotIn('abbr', $existingLangs);
@endphp


<x-dashboard.layout :title="__('label.new_language')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.languages') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.languages.index') }}">
                                {{ __('label.languages') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_language') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_language') }}</h4>
            </div>
            <form action="{{ route('admin.languages.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label for="flag" class="form-label">
                                    {{ __('label.selectLanguages') }}
                                </label>
                                <select id="select2WithOptionIcon" name="langs[]" class="select2 form-select" multiple
                                    style="direction:ltr">
                                    @foreach ($langs as $lang)
                                        <option value="{{ json_encode($lang) }}"
                                            data-icon="flag-icon-{{ $lang['flag'] }}">
                                            {{ __('locale.' . $lang['abbr']) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="name">
                                    {{ __('label.name') }}
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="{{ __('label.name') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="direction">{{ __('label.direction') }}</label>
                                <select id="direction" name="direction" class="form-select">
                                    <option value="" selected disabled>
                                        {{ __('label.select_direction') }}
                                    </option>
                                    <option value="rtl" @selected(old('direction') === 'rtl')>
                                        {{ __('label.rtl') }}
                                    </option>
                                    <option value="ltr" @selected(old('direction') === 'ltr')>
                                        {{ __('label.ltr') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="abbr">
                                    {{ __('label.abbr') }}
                                </label>
                                <input type="abbr" id="abbr" name="abbr" value="{{ old('abbr') }}"
                                    class="form-control" placeholder="{{ __('label.abbr') }}" />
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="active">
                                    {{ __('label.status') }}
                                </label>
                                <div class="form-check form-check-success form-switch">
                                    <input type="checkbox" name="active" value="1" checked
                                        @checked(old('active') === '1') class="form-check-input status" id="active"
                                        style="cursor:pointer;" />
                                </div>
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
