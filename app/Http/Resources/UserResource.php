<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $details = optional($this->podcasterDetails);
        $category = optional($details->category);

        $data = [
            'id' => $this->id,
            'user_type' => $this->type,
            'name' => $this->name,
            'profile_img' => displayFile($this->profile_img),
            'email' => $this->email,
            'phone' => $this->phone,
            'bio' => $details->bio,
            'facebook' => $details->facebook,
            'youtube' => $details->youtube,
            'instagram' => $details->instagram,
            'twitter' => $details->twitter,
            'snapchat' => $details->snapchat,
            'tiktok' => $details->tiktok,
            'linkedin' => $details->linkedin,
            'category' => $category ? new CategoryResource($category) : null,
            'channel' => $this->relationLoaded('channel') ? new ChannelResource($this->channel) : null,
        ];

        if (isset($this->followers_count)) {
            $data['followers_count'] = (string) $this->followers_count;
        }

        if (isset($this->is_following)) {
            $data['is_following'] = (bool) $this->is_following;
        }

        return $data;
    }
}
