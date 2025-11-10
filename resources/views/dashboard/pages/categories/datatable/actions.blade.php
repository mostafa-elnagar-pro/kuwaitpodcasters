<div class="table-act-btn gap-1">
    @permission('categories-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.categories.show', $category) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('categories-update')
        <button type="button" class="btn btn-outline-success waves-effect"
            onclick="window.location.href='{{ route('admin.categories.edit', $category) }}'">
            <i class="bi bi-pencil"></i>
        </button>
    @endpermission

    @permission('categories-delete')
        <x-dashboard.delete-item :item="$category" resource="categories">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $category->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
