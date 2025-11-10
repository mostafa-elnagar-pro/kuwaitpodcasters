<x-dashboard.layout :title="__('label.new_category')">

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
                            {{ __('label.new_category') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_category') }}</h4>
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <x-dashboard.lang-tabs :$activeLangs />

                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($activeLangs as $lang)
                            <div class="tab-pane fade {{ $loop->first ? 'active' : '' }} show" id="{{ $lang->abbr }}"
                                role="tabpanel" aria-labelledby="nav-{{ $lang->abbr }}" tabindex="0">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="mb-2">
                                            <label class="form-label" for="name">
                                                {{ formatLangLabel('name', $lang->abbr) }}
                                            </label>
                                            <input type="text" id="name" name="name[{{ $lang->abbr }}]"
                                                value="{{ old("name.$lang->abbr") }}" class="form-control"
                                                placeholder="{{ __('label.name') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12 d-flex align-items-center parent">
                            <div class="mb-2 flex-grow-1">
                                <label for="image" class="form-label">
                                    {{ __('label.image') }}
                                </label>
                                <input type="file" id="image" name="image" class="form-control image"
                                    accept=".jpg,.jpeg,.png,.svg" />
                                <i class="d-inline-block mt-50 mx-1 text-secondary" style="font-size:14px">
                                    ratio ( 1 : 1 )  ex  90px * 90px
                                </i>
                            </div>
                            <img id="preview_img" class="preview rounded" />
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="is_active">{{ __('label.status') }}</label>
                                <x-dashboard.select name="is_active">
                                    <option value="1" @selected(old('is_active') == '1')>
                                        {{ __('label.active') }}
                                    </option>
                                    <option value="0" @selected(old('is_active') == '0')>
                                        {{ __('label.inactive') }}
                                    </option>
                                </x-dashboard.select>
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
