<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'author' => $this->author,
            'summary' => $this->summary,
            'publication_year' => $this->publication_year,
            'publisher' => $this->publisher,
            'created_at' => formatDate($this->created_at),
        ];
    }
}
