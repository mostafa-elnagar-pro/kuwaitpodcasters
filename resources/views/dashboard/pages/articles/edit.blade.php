<x-dashboard.layout :title="__('label.edit_article')">

    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.articles') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.articles.index') }}">
                                {{ __('label.articles') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.edit_article') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection


    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.edit_article') }}</h4>
            </div>
            <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PUT')

                <div class="card-body">
                    <x-dashboard.lang-tabs :$activeLangs />

                    <div class="row">
                        <div class="col-md-6 col-12 d-flex align-items-center gap-2 parent">
                            <div class="mb-2 flex-grow-1">
                                <label for="image" class="form-label">
                                    {{ __('label.image') }}
                                </label>
                                <input type="file" id="image" name="image" class="form-control image"
                                    accept=".jpg,.jpeg,.png,.webp">
                                <i class="d-inline-block mt-50 mx-1 text-secondary" style="font-size:14px">
                                    ratio: ( 2 ∶ 1 ) ex 412px * 206px
                                </i>
                            </div>
                            <img src="{{ displayFile($article->image) }}" id="image" class="preview rounded"
                                width="60px" />
                        </div>

                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($activeLangs as $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'active' : '' }} show"
                                    id="{{ $lang->abbr }}" role="tabpanel" aria-labelledby="nav-{{ $lang->abbr }}"
                                    tabindex="0">

                                    <div class="row">
                                        <div class="mb-2">
                                            <label class="form-label" for="title">
                                                {{ formatLangLabel('title', $lang->abbr) }}
                                            </label>
                                            <input type="text" id="title" name="title[{{ $lang->abbr }}]"
                                                value="{{ old("title.$lang->abbr", $article->getTranslation('title', $lang->abbr) ?? '') }}"
                                                class="form-control" placeholder="{{ __('label.title') }}" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-2">
                                            <label class="form-label" for="short_body">
                                                {{ formatLangLabel('short_body', $lang->abbr) }}
                                            </label>
                                            <textarea rows="2" id="short_body" name="short_body[{{ $lang->abbr }}]" class="form-control"
                                                placeholder="{{ __('label.short_body') }}">{{ old("short_body.$lang->abbr", $article->getTranslation('short_body', $lang->abbr) ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-2">
                                            <label class="form-label" for="body">
                                                {{ formatLangLabel('body', $lang->abbr) }}
                                            </label>

                                            @php
                                                $bodyValue = old(
                                                    "body.$lang->abbr",
                                                    $article->getTranslation('body', $lang->abbr),
                                                );
                                            @endphp
                                            <x-dashboard.ckeditor5 :$lang name="body" :value="$bodyValue" />
                                        </div>
                                    </div>

                                </div>
                            @endforeach
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
