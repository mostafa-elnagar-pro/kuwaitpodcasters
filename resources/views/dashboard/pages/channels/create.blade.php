<x-dashboard.layout :title="__('label.new_channel')">



    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.channels') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.channels.index') }}">
                                {{ __('label.channels') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_channel') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_channel') }}</h4>
            </div>
            <form action="{{ route('admin.channels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="user_id">{{ __('label.podcaster') }}</label>
                                <select id="select2WithOptionIcon" name="user_id" class="select2 form-select">
                                    <option value="" selected disabled>
                                        {{ __('label.select_podcaster') }}
                                    </option>
                                    @foreach ($podcasters as $podcaster)
                                        <option value="{{ $podcaster->id }}"
                                            data-img="{{ displayFile($podcaster->profile_img) }}"
                                            @selected(old('user_id') === $podcaster->id)>
                                            {{ $podcaster->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="name">
                                    {{ __('label.name') }}
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="{{ __('label.name') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12 d-flex align-items-center gap-2 parent">
                            <div class="mb-2 flex-grow-1">
                                <label for="image" class="form-label">
                                    {{ __('label.image') }}
                                </label>
                                <input type="file" id="image" name="image" class="form-control image"
                                    accept=".jpg,.jpeg,.png,.webp">
                                <i class="d-inline-block mt-50 mx-1 text-secondary" style="font-size:14px">
                                    760px * 810px
                                </i>
                            </div>
                            <img id="image" class="preview rounded" width="60px" />
                        </div>

                        <div class="col-12">
                            <div class="mb-2">
                                <label class="form-label" for="description">
                                    {{ __('label.description') }}
                                </label>
                                <textarea rows="2" id="description" name="description" class="form-control"
                                    placeholder="{{ __('label.description') }}">{{ old('description') }}</textarea>
                                {{-- <x-dashboard.quill-editor :value="old('description')" /> --}}
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

    @push('js')
        <x-dashboard.scripts.select2-img-option />
    @endpush



    </x-dashboard.layout.master>
