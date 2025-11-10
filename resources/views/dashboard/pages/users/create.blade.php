<x-dashboard.layout :title="__('label.new_user')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.users') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users.index') }}">
                                {{ __('label.users') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.add') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_user') }}</h4>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="name">
                                    {{ __('label.name') }}
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="{{ __('label.name') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="email">
                                    {{ __('label.email') }}
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="form-control" placeholder="{{ __('label.email') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="phone">
                                    {{ __('label.phone') }}
                                </label>
                                <div class="d-flex gap-50">
                                    <div class="w-50">
                                        <select id="country" name="country" class="select2 form-select">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->code . '@' . $country->id }}"
                                                    @selected(old('country') == $country->code . '@' . $country->id)>
                                                    {{ '(' . $country->code . ')' . ' ' . $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                        class="flex-grow-1 form-control" placeholder="{{ __('label.phone') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12 d-flex align-items-center parent">
                            <div class="mb-2 flex-grow-1">
                                <label for="profile_img" class="form-label">
                                    {{ __('label.profile_img') }}
                                </label>
                                <input type="file" id="profile_img" name="profile_img" class="form-control image"
                                    accept=".jpg,.jpeg,.png">
                            </div>
                            <img id="preview_img" class="preview rounded" />
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="password">
                                    {{ __('label.password') }}
                                </label>

                                <x-dashboard.password-input />
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
