<x-dashboard.layout :title="__('label.new_book')">
    @section('breadcrumb')
        <div class="content-header-left mb-2">
            <div class="breadcrumbs-top">
                <h2 class="content-header-title float-start mb-0">
                    {{ __('label.books') }}
                </h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">
                                {{ __('label.home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.books.index') }}">
                                {{ __('label.books') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('label.new_book') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('label.new_book') }}</h4>
            </div>
            <form action="{{ route('admin.books.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <x-dashboard.lang-tabs :$activeLangs />

                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($activeLangs as $lang)
                            <div class="tab-pane fade {{ $loop->first ? 'active' : '' }} show"
                                id="{{ $lang->abbr }}" role="tabpanel" aria-labelledby="nav-{{ $lang->abbr }}"
                                tabindex="0">

                                <div class="row">
                                    <div class="mb-2">
                                        <label class="form-label" for="name">
                                            {{ formatLangLabel('book_name', $lang->abbr) }}
                                        </label>
                                        <input type="text" id="name" name="name[{{ $lang->abbr }}]"
                                            value="{{ old("name.$lang->abbr") }}" class="form-control"
                                            placeholder="{{ __('label.book_name') }}" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2">
                                        <label class="form-label" for="author">
                                            {{ formatLangLabel('author', $lang->abbr) }}
                                        </label>
                                        <input type="text" id="author" name="author[{{ $lang->abbr }}]"
                                            value="{{ old("author.$lang->abbr") }}" class="form-control"
                                            placeholder="{{ __('label.author') }}" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2">
                                        <label class="form-label" for="summary">
                                            {{ formatLangLabel('summary', $lang->abbr) }}
                                        </label>
                                        <textarea rows="4" id="summary" name="summary[{{ $lang->abbr }}]" class="form-control"
                                            placeholder="{{ __('label.summary') }}">{{ old("summary.$lang->abbr") }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2">
                                        <label class="form-label" for="publisher">
                                            {{ formatLangLabel('publisher', $lang->abbr) }}
                                        </label>
                                        <input type="text" id="publisher" name="publisher[{{ $lang->abbr }}]"
                                            value="{{ old("publisher.$lang->abbr") }}" class="form-control"
                                            placeholder="{{ __('label.publisher') }}" />
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="mb-2">
                            <label class="form-label" for="publication_year">
                                {{ __('label.publication_year') }}
                            </label>
                            <input type="number" id="publication_year" name="publication_year"
                                value="{{ old('publication_year') }}" class="form-control"
                                placeholder="{{ __('label.publication_year') }}" min="1000" max="{{ date('Y') }}" />
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

