<?php

namespace App\Models;

use App\Models\Scopes\ActiveCategoryScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use HasFactory,
        HasTranslations,
        Searchable;

    protected $fillable = [
        'name',
        'image',
        'is_active'
    ];

    protected $translatable = [
        'name'
    ];


    protected function casts(): array
    {
        return [
            'name' => 'array',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new ActiveCategoryScope());
    }


    public function podcasts(): HasManyThrough
    {
        return $this->hasManyThrough(Podcast::class, PodcasterDetails::class, 'category_id', 'user_id', 'id', 'user_id');
    }
}
