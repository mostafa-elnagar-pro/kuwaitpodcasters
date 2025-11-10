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
                            {{ __('label.audios') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <div class="row">
        @foreach ($settings as $setting)
            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('admin.settings.update', $setting) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="type" value="audio" />
                        <input type="hidden" name="key" value="{{ $setting->key }}" />

                        <div class="card-body">
                            <div class="form-group">
                                <label for="setting_{{ $setting->id }}"
                                    style="font-weight:600;font-size:15px">{{ __("label.$setting->key") }}</label>
                                <input type="file" class="form-control mt-50" id="setting_{{ $setting->id }}"
                                    name="file" onchange="previewAudio(event, {{ $setting->id }})"
                                    accept="audio/*">
                            </div>

                            <x-dashboard.preview-audio-player :item="$setting" />
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">
                                {{ __('action.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    </x-dashboard.layout.master>
