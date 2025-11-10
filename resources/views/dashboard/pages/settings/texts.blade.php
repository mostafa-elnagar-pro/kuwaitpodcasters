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
                            {{ __('label.texts') }}
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
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Texts Tab -->
                        <div class="tab-pane fade show active" id="pills-texts" role="tabpanel"
                            aria-labelledby="pills-texts-tab">
                            <div class="card">
                                <form action="{{ route('admin.settings.updateTexts') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-header">
                                        <button type="submit"
                                            class="btn btn-primary waves-effect waves-float waves-light">
                                            {{ __('action.save') }}
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        @foreach ($settings as $setting)
                                            <div class="flex-grow-1 form-floating {{ $loop->first ? 'mt-2' : 'mt-3' }}">
                                                <input type="text" class="form-control"
                                                    id="setting_{{ $setting->key }}"
                                                    name="settings[][{{ $setting->key }}]"
                                                    value="{{ $setting->value }}">
                                                <label for="setting_{{ $setting->key }}"
                                                    style="font-weight:600;font-size:15px">{{ __("label.$setting->key") }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    </x-dashboard.layout.master>
