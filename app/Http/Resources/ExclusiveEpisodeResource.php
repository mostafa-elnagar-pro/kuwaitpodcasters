<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExclusiveEpisodeResource extends JsonResource
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
            'link' => displayFile($this->link),
            'created_at' => formatDate($this->created_at),
        ];

        if ($this->relationLoaded('podcaster')) {
            $data['podcaster'] = [
                'id' => $this->podcaster->id,
                'name' => $this->podcaster->name,
            ];
        }

        if ($this->relationLoaded('channel')) {
            $data['channel'] = [
                'id' => $this->channel->id,
                'name' => $this->channel->name,
            ];
        }

        if ($this->relationLoaded('season')) {
            $data['season'] = [
                'id' => $this->season->id,
                'name' => $this->season->name,
            ];
        }

        return $data;
    }
}
