@foreach ($comments as $comment)
    <div class="review-card">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-1">
                <img src="{{ displayFile($comment->user?->profile_img, 'default-user.svg') }}" class="rounded-circle"
                    alt="user avatar" width="45" height="45">
                <div>
                    <h6 class="mb-0">{{ $comment->user?->name }}</h6>
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
        <p class="mt-3 fs-6">{{ $comment->comment }}</p>
    </div>
@endforeach
