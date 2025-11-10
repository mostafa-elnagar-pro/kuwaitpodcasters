<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PodcastResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => displayFile($this->image),
            'description' => $this->description,
            'media_type' => $this->media_type,
            'media_source' => $this->media_source,
            'duration' => $this->duration,
            'link' => displayFile($this->link),
            'likes_count' => (string) ($this->likes_count ?? 0),
            'views_count' => (string) ($this->views_count ?? 0),
            'in_favourites' => (bool) $this->in_favourites,
            'created_at' => formatDate($this->created_at)
        ];

        if ($this->relationLoaded('podcaster')) {
            $data['podcaster_id'] = $this->podcaster->id;
            $data['podcaster_img'] = displayFile($this->podcaster->profile_img);
            $data['podcaster_name'] = $this->podcaster->name;
            $data['category_name'] = $this->podcaster->category->name;
        }

        if ($this->relationLoaded('channel')) {
            $data['channel_id']= $this->channel->id;
        }

        if ($this->relationLoaded('season')) {
            $data['season_id']= $this->season->id;
        }

        return $data;
    }
}
