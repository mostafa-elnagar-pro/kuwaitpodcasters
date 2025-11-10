<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\User;


class ChannelPolicy
{
    public function create(User $user, Channel $channel): bool
    {
        return $channel->user_id === $user->id;
    }

    public function update(User $user, Channel $channel): bool
    {
        return $channel->user_id === $user->id;
    }

    public function delete(User $user, Channel $channel): bool
    {
        return $channel->user_id === $user->id;
    }
}
