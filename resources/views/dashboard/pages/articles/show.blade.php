<x-dashboard.layout :title="__('label.article_details')">

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
                            {{ __('label.view') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endsection

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('label.article_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('articles-update')
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('articles-delete')
                            <x-dashboard.delete-item :item="$article" resource="articles">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $article->id }}">
                                    <i class="fa fa-trash"></i>
                                    {{ __('action.delete') }}
                                </button>
                            </x-dashboard.delete-item>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-datatable">
                        <table class="table table-responsive" id="table">
                            <tr>
                                <th>#</th>
                                <td>{{ $article->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.image') }}</th>
                                <td>
                                    <img src="{{ displayFile($article->image) }}" alt="image" width="100px" />
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('label.title') }}</th>
                                <td>{{ $article->title }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.short_body') }}</th>
                                <td>{{ $article->short_body }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.body') }}</th>
                                <td style="background:#eeeeee57">{!! $article->body !!}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($article->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

    </x-dashboard.layout.master>
