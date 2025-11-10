<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'is_owner' => $this->user_id === auth()->id(),
            'name' => $this->name,
            'description' => $this->description,
            'image' => displayFile($this->image),
            'seasons_count' => (string) ($this->seasons_count ?? 0),
            'podcasts_count' => (string) ($this->podcasts_count ?? 0),
            'created_at' => formatDate($this->created_at),
        ];

        if ($this->relationLoaded('owner')) {
            $data['owner_id'] = $this->owner->id;
            $data['owner_name'] = $this->owner->name;
            $data['owner_img'] = displayFile($this->owner->profile_img);

            if ($this->owner->relationLoaded('category')) {
                $data['category_name'] = $this->owner->category?->name;
            }
        }

        return $data;
    }
}
