<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "type" => $this->type,
            "data" => $this->data,
            "opened" => !is_null($this->read_at),
            "created_at" => formatDate($this->created_at, true),
        ];
    }
}
