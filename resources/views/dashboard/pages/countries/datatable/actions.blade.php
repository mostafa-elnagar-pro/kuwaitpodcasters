<div class="table-act-btn gap-1">
    @permission('countries-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.countries.show', $country) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission

    @permission('countries-delete')
        <x-dashboard.delete-item :item="$country" resource="countries">
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                data-bs-target="#deleteRecord{{ $country->id }}">
                <i class="bi bi-trash"></i>
            </button>
        </x-dashboard.delete-item>
    @endpermission
</div>
