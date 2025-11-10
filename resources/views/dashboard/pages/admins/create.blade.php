<x-dashboard.layout :title="__('label.new_admin')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.admins') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.admins.index') }}">
                                {{ __('label.admins') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_admin') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_admin') }}</h4>
            </div>
            <form action="{{ route('admin.admins.store') }}" method="POST">

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
                                <label class="form-label" for="password">
                                    {{ __('label.password') }}
                                </label>

                                <x-dashboard.password-input />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="role">{{ __('label.role') }}</label>
                                <select id="role" name="role" class="select2 form-select">
                                    <option value="" selected disabled>
                                        {{ __('label.select_role') }}
                                    </option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @selected(old('role') == $role->id)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
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
