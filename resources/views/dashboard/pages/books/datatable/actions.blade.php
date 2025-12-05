<div class="table-act-btn gap-1">
    @permission('books-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.books.show', $book) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('books-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.books.edit', $book) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('books-delete')
        <x-dashboard.delete-item :item="$book" resource="books">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $book->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>

