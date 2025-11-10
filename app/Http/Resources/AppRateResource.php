<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppRateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => (float) $this->value,
            'message' => $this->message,
            'user_name'=> $this->user->name,
            'user_img'=> displayFile($this->user->profile_img), 
            'created_at' => formatDate($this->created_at),
            'updated_at' => formatDate($this->updated_at)
        ];
    }
}
