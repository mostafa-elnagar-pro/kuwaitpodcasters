<x-dashboard.layout :title="__('label.book_details')">

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
                    <h4 class="card-title">{{ __('label.book_details') }}</h4>
                    <div class="btns-top gap-1">
                        @permission('books-update')
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-success">
                                <i class="fa fa-pencil"></i>
                                {{ __('action.edit') }}
                            </a>
                        @endpermission
                        @permission('books-delete')
                            <x-dashboard.delete-item :item="$book" resource="books">
                                <button class="btn btn-danger waves-effect" data-bs-toggle="modal"
                                    data-bs-target="#deleteRecord{{ $book->id }}">
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
                                <td>{{ $book->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.book_name') }}</th>
                                <td>{{ $book->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.author') }}</th>
                                <td>{{ $book->author }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.summary') }}</th>
                                <td>{{ $book->summary }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.publication_year') }}</th>
                                <td>{{ $book->publication_year }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.publisher') }}</th>
                                <td>{{ $book->publisher }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('label.created_at') }}</th>
                                <td>{{ formatDate($book->created_at) }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

    </x-dashboard.layout.master>

