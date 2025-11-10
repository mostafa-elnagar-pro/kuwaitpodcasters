@props(['item'])

{{ $slot }}

<!-- Notify User Modal -->
<div class="modal fade" id="notifyUser{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-xl">{{ __('label.send_notification') }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route("admin.users.notify", $item) }}">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-2 d-flex flex-column align-items-start">
                                <label class="form-label" for="title">
                                    {{ __('label.title') }}
                                </label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}"
                                    class="w-100 form-control" placeholder="{{ __('label.title') }}" />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex flex-column align-items-start">
                                <label class="form-label" for="body">
                                    {{ __('label.body') }}
                                </label>
                                <textarea rows="2" id="body" name="body" class="form-control" placeholder="{{ __('label.body') }}">{{ old('body') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn w-inherit" data-bs-dismiss="modal">
                        {{ __('action.cancel') }}
                    </button>
                    <button class="btn btn-danger w-inherit">
                        {{ __('action.send') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
