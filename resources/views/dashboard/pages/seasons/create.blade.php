<x-dashboard.layout :title="__('label.new_season')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.seasons') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.seasons.index') }}">
                                {{ __('label.seasons') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_season') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_season') }}</h4>
            </div>
            <form action="{{ route('admin.seasons.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <label class="form-label" for="channel_id">{{ __('label.channel') }}</label>
                                <select name="channel_id" class="select2 form-select">
                                    <option value="" selected disabled>
                                        {{ __('label.select_channel') }}
                                    </option>
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" @selected(old('channel_id') === $channel->id)>
                                            {{ $channel->name }}
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
