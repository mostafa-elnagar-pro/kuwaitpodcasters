<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PodcastCommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                ...$this->user->toArray(),
                'profile_img' => displayFile($this->user->profile_img, 'default-user.svg')
            ],
            'comment' => $this->comment,
            'created_at' => $this->created_at->diffforHumans(),
        ];
    }
}
