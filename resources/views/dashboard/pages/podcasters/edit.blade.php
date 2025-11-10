<x-dashboard.layout :title="__('label.edit_podcaster')">

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
                            {{ __('label.edit') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.edit_podcaster') }}</h4>
            </div>
            <form action="{{ route('admin.podcasters.update', $podcaster) }}" method="POST"
                enctype="multipart/form-data">

                @csrf

                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="name">
                                    {{ __('label.name') }}
                                </label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $podcaster->name ?? '') }}" class="form-control"
                                    placeholder="{{ __('label.name') }}" />
                            </div>
                        </div>


                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="email">
                                    {{ __('label.email') }}
                                </label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $podcaster->email ?? '') }}" class="form-control"
                                    placeholder="{{ __('label.email') }}" />
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
                                                    @selected(old('country', $podcaster->country ?? '') == $country->code . '@' . $country->id)>
                                                    {{ $country->code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" id="phone" name="phone"
                                        value="{{ old('phone', $podcaster->phone ?? '') }}"
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
                            <img src="{{ displayFile($podcaster->profile_img) }}" id="preview_img"
                                class="preview rounded" />
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="password">
                                    {{ __('label.password') }}
                                </label>

                                <x-dashboard.password-input />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="status">{{ __('label.status') }}</label>
                                <x-dashboard.select name="status">
                                    <option value="" disabled selected>
                                        {{ __('label.status') }}
                                    </option>
                                    @if ($podcaster->status === 'pending')
                                        <option value="pending" selected>{{ __('label.pending') }}</option>
                                    @endif
                                    <option value="active" @selected(old('status', $podcaster->status ?? '') === 'active')>
                                        {{ __('label.active') }}
                                    </option>
                                    <option value="inactive" @selected(old('status', $podcaster->status ?? '') === 'inactive')>
                                        {{ __('label.inactive') }}
                                    </option>
                                </x-dashboard.select>
                            </div>
                        </div>


                        <hr class="my-2" />

                        <!-- Podcaster Details (only show on type='podcaster') -->
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
                                            <option value="{{ $category->id }}" @selected(old('category_id', $podcaster->podcasterDetails->category->id ?? '') == $category->id)>
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
                                    <textarea rows="1" id="bio" name="bio" class="form-control" placeholder="{{ __('label.bio') }}">{{ old('bio', $podcaster->podcasterDetails->bio ?? '') }}</textarea>
                                </div>
                            </div>

                            <x-dashboard.social-input name="facebook" :details="$podcaster->podcasterDetails" />
                            <x-dashboard.social-input name="youtube" :details="$podcaster->podcasterDetails" />
                            <x-dashboard.social-input name="instagram" :details="$podcaster->podcasterDetails" />
                            <x-dashboard.social-input name="twitter" :details="$podcaster->podcasterDetails" />
                            <x-dashboard.social-input name="snapchat" :details="$podcaster->podcasterDetails" />
                            <x-dashboard.social-input name="tiktok" :details="$podcaster->podcasterDetails" />
                            <x-dashboard.social-input name="linkedin" :details="$podcaster->podcasterDetails" />
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
