<?php

namespace App\Policies;

use App\Models\PodcastComment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PodcastCommentPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PodcastComment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    public function delete(User $user, PodcastComment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}
