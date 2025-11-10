<div class="table-act-btn gap-1">
    @permission('articles-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.articles.show', $article) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('articles-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.articles.edit', $article) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('articles-delete')
        <x-dashboard.delete-item :item="$article" resource="articles">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $article->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
