<x-dashboard.layout :title="__('label.edit_channel')">



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
                            {{ __('label.edit_channel') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.edit_channel') }}</h4>
            </div>
            <form action="{{ route('admin.channels.update', $channel) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="name">
                                    {{ __('label.name') }}
                                </label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $channel->name) }}" class="form-control"
                                    placeholder="{{ __('label.name') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12 d-flex align-items-center gap-2 parent">
                            <div class="mb-2 flex-grow-1">
                                <label for="image" class="form-label">
                                    {{ __('label.image') }}
                                </label>
                                <input type="file" id="image" name="image" class="form-control image"
                                    accept=".jpg,.jpeg,.png">
                                <i class="d-inline-block mt-50 mx-1 text-secondary" style="font-size:14px">
                                    ratio (19 : 8)
                                </i>
                            </div>
                            <img src="{{ displayFile($channel->image) }}" id="image" class="preview rounded"
                                width="60px;" />
                        </div>


                        <div class="col-12">
                            <div class="mb-2">
                                <label class="form-label" for="description">
                                    {{ __('label.description') }}
                                </label>
                                <textarea rows="2" id="description" name="description" class="form-control"
                                    placeholder="{{ __('label.description') }}">{{ old('description', $channel->description) }}</textarea>
                                {{-- <x-dashboard.quill-editor :value="old('description', $channel->description)" /> --}}
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
