<x-dashboard.layout :title="__('label.edit_language')">

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
                            {{ __('label.edit_language') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.edit_language') }}</h4>
            </div>
            <form action="{{ route('admin.languages.update', $language) }}" method="POST">
                @csrf

                @method('PUT')

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
                                                value="{{ old("name.$lang->abbr", $language->getTranslation('name', $lang->abbr)) }}"
                                                class="form-control" placeholder="{{ __('label.name') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="mb-2">
                            <label class="form-label" for="active">
                                {{ __('label.status') }}
                            </label>
                            <div class="form-check form-check-success form-switch">
                                <input type="checkbox" name="active" value="1" @checked(old('active', $language->is_active) == '1')
                                    class="form-check-input status" id="active" style="cursor:pointer;" />
                            </div>
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
