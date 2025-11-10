<x-dashboard.layout :title="__('label.new_podcaster')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.podcasters') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.podcasters.index') }}">
                                {{ __('label.podcasters') }}
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
                <h4 class="card-title">{{ __('label.new_podcaster') }}</h4>
            </div>
            <form action="{{ route('admin.podcasters.store') }}" method="POST" enctype="multipart/form-data">

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
                                <span class="d-inline-block mt-50 mx-1 text-secondary" style="font-size:14px">
                                    400px * 400px
                                </span>
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

                        <hr class="my-2" />

                        <div id="podcasterDetails" class="row">
                            <h4 class="mb-2 text-secondary">{{ __('label.podcaster_details') }}</h4>

                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="category_id">{{ __('label.category') }}</label>
                                    <select id="category_id" name="category_id" class="select2 form-select">
                                        <option value="" selected disabled>
                                            {{ __('label.select_category') }}
                                        </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="bio">
                                        {{ __('label.bio') }}
                                    </label>
                                    <textarea rows="1" id="bio" name="bio" class="form-control" placeholder="{{ __('label.bio') }}">{{ old('bio') }}</textarea>
                                </div>
                            </div>

                            <x-dashboard.social-input name="facebook" />
                            <x-dashboard.social-input name="youtube" />
                            <x-dashboard.social-input name="instagram" />
                            <x-dashboard.social-input name="twitter" />
                            <x-dashboard.social-input name="snapchat" />
                            <x-dashboard.social-input name="tiktok" />
                            <x-dashboard.social-input name="linkedin" />
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
