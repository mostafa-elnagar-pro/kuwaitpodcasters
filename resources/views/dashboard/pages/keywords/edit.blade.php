<x-dashboard.layout :title="__('label.edit_keyword')">



    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.keywords') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.keywords.index') }}">
                                {{ __('label.keywords') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.edit_keyword') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.edit_keyword') }}</h4>
            </div>
            <form action="{{ route('admin.keywords.update', $keyword) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PUT')

                <div class="card-body">
                    <x-dashboard.lang-tabs :$activeLangs />

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="type">
                                    {{ __('label.type') }}
                                </label>
                                <x-dashboard.select name="type">
                                    <option value="web" @selected($keyword->type === 'web')>{{ __('label.web') }}</option>
                                    <option value="mobile" @selected($keyword->type === 'mobile')>{{ __('label.mobile') }}</option>
                                </x-dashboard.select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="key">
                                    {{ __('label.key') }}
                                </label>
                                <input type="text" id="key" name="key"
                                    value="{{ old('key', $keyword->key) }}" class="form-control"
                                    placeholder="{{ __('label.key') }}" />
                            </div>
                        </div>

                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($activeLangs as $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'active' : '' }} show"
                                    id="{{ $lang->abbr }}" role="tabpanel" aria-labelledby="nav-{{ $lang->abbr }}"
                                    tabindex="0">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="value">
                                                    {{ formatLangLabel('value', $lang->abbr) }}
                                                </label>
                                                <input type="text" id="value" name="value[{{ $lang->abbr }}]"
                                                    value="{{ old("value.$lang->abbr", $keyword->getTranslation('value', $lang->abbr)) }}"
                                                    class="form-control" placeholder="{{ __('label.value') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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

    @push('js')
        <x-dashboard.scripts.select2-img-option />
    @endpush



    </x-dashboard.layout.master>
