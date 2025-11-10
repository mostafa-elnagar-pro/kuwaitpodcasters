<?php

namespace App\Traits;

use App\Models\User;

trait Followable
{
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'user_id');
    }

    public function isFollowedBy($followerId)
    {
        return $this->followers()->where('user_id', $followerId)->exists();
    }


    public function scopeWithFollows($query)
    {
        return $query->withCount('followers')
            ->withExists([
                'followers as is_following' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ]);
    }

}
