<div class="table-act-btn gap-1">
    @permission('app_rates-read')
        <button type="button" class="btn btn-outline-info waves-effect"
            onclick="window.location.href='{{ route('admin.app_rates.show', $app_rate) }}'">
            <i class="bi bi-eye"></i>
        </button>
    @endpermission
    @if (!request()->boolean('no_delete'))
        @permission('app_rates-delete')
            <x-dashboard.delete-item :item="$app_rate" resource="app_rates">
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal"
                    data-bs-target="#deleteRecord{{ $app_rate->id }}">
                    <i class="bi bi-trash"></i>
                </button>
            </x-dashboard.delete-item>
        @endpermission
    @endif
</div>
