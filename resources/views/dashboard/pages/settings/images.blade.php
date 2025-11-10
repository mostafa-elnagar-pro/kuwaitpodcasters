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
                            {{ __('label.images') }}
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
                    <div class="card-header">
                        <h3 style="font-weight:600;font-size:15px">
                            {{ __("label.$setting->key") }}
                        </h3>
                        <!-- Remove setting image form -->
                        @if ($setting->value)
                            <form id="remove_setting{{ $setting->id }}" action="{{ route('admin.settings.delete', $setting) }}" method="POST">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger waves-effect waves-float waves-light">
                                    {{ __('action.delete') }}
                                </button>
                            </form>
                        @endif

                        <!-- add setting image button (triggers add form) -->
                        <button type="submit" id="add_setting{{ $setting->id }}" form="add_form{{ $setting->id }}"
                            class="btn btn-primary waves-effect waves-float waves-light d-none">
                            {{ __('action.save') }}
                        </button>
                    </div>

                    <div class="card-body parent">
                        <form id="add_form{{ $setting->id }}" action="{{ route('admin.settings.update', $setting) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="type" value="image" />
                            <input type="hidden" name="key" value="{{ $setting->key }}" />

                            <div class="form-group">
                                <input type="file" class="form-control mt-50 image" id="setting_{{ $setting->id }}"
                                    name="file" accept=".jpg,.jpeg,.png" required>
                                <i class="d-inline-block mt-50 mx-1 text-secondary" style="font-size:14px">
                                    {{ $setting->note }}
                                </i>
                            </div>

                            <img src="{{ displayFile($setting->value) }}" id="preview_img"
                                style="width:200px;height:150px;object-fit:contain" class="mt-1 preview rounded" />

                        </form>
                    </div>

                    @push('js')
                        <script>
                            $(document).ready(function() {
                                $("#setting_{{ $setting->id }}").on('change', function() {
                                    if ($(this).val()) {
                                        $("#remove_setting{{ $setting->id }}").addClass('d-none');
                                        $("#add_setting{{ $setting->id }}").removeClass('d-none');
                                    } else {
                                        $("#remove_setting{{ $setting->id }}").addClass('d-none');
                                        $("#add_setting{{ $setting->id }}").removeClass('d-none');
                                    }
                                })
                            })
                        </script>
                    @endpush
                </div>
            </div>
        @endforeach
    </div>

    </x-dashboard.layout.master>
