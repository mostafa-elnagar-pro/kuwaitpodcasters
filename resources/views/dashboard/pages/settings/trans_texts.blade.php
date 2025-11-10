<x-dashboard.layout :title="__('label.settings')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.settings') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.settings') }}
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.trans_texts') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <div class="row">
        <div class="col-12">
            <div class="card " style="background:#EDEDED29">
                <div class="card-body">
                    <!-- Tab Panes -->
                    <div class="row">
                        @foreach ($settings as $setting)
                            <div class="card {{ $loop->first ? '' : 'mt-3' }}">
                                <form action="{{ route('admin.settings.update', $setting) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="type" value="trans_text" />
                                    <input type="hidden" name="key" value="{{ $setting->key }}" />

                                    <div class="card-header">
                                        <label for="setting_{{ $setting->key }}"
                                            style="font-weight:600;font-size:15px">{{ __("label.$setting->key") ?? 'hello' }}</label>

                                        <button type="submit"
                                            class="btn btn-primary waves-effect waves-float waves-light">
                                            {{ __('action.save') }}
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="nav-tabContent">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    @foreach ($activeLangs as $lang)
                                                        <button
                                                            class="nav-link {{ $loop->first ? 'show active' : '' }}"
                                                            id="nav_{{ $setting->key . '_' . $lang->abbr }}"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#{{ $setting->key . '_' . $lang->abbr }}"
                                                            type="button" role="tab"
                                                            aria-controls="nav-{{ $lang->abbr }}"
                                                            aria-selected="true">
                                                            {{ __("locale.$lang->abbr") }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </nav>

                                            @foreach ($activeLangs as $lang)
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                    id="{{ $setting->key . '_' . $lang->abbr }}" role="tabpanel"
                                                    aria-labelledby="nav_{{ $setting->key . '_' . $lang->abbr }}"
                                                    tabindex="0" style="margin-top: -30px;">


                                                    <x-dashboard.ckeditor5 
                                                        :$lang 
                                                        name="trans_value" 
                                                        height="250px"
                                                        :id="$setting->key . uniqid() . $lang->abbr" 
                                                        :value="old('trans_value' . $setting->key . $lang->abbr, $setting->getTranslation('trans_value', $lang->abbr))" 
                                                    />
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
