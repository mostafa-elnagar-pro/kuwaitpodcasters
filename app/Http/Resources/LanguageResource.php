<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'abbr' => $this->abbr,
            'name' => $this->name,
            'direction' => $this->direction,
            'flag' => displayFlag($this->flag)
        ];
    }
}
