<x-dashboard.layout :title="__('label.new_slider')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.sliders') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.sliders.index') }}">
                                {{ __('label.sliders') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_slider') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_slider') }}</h4>
            </div>
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12 d-flex flex-column gap-2 parent">
                            <div class="mb-2 flex-grow-1">
                                <label for="image" class="form-label">
                                    {{ __('label.image') }}
                                </label>
                                <input type="file" id="image" name="image" class="form-control image"
                                    accept=".jpg,.jpeg,.png,.webp">
                                <i class="d-inline-block mt-50 mx-1 text-secondary" style="font-size:14px">
                                    ratio( 2.1  :   1 )  with max width  1900px
                                </i>
                            </div>
                            <img id="image" class="preview rounded"
                                style="max-width:100%;max-height:300px;object-fit:cover;" />
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
