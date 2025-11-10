<div class="table-act-btn gap-1">
    @permission('podcasts-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.podcasts.show', $podcast) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('podcasts-delete')
        <x-dashboard.delete-item :item="$podcast" resource="podcasts">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $podcast->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
