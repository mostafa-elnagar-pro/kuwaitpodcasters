<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Channel extends Model
{
    use Searchable;

    protected $fillable = [
        'user_id',
        'image',
        'name',
        'description'
    ];

    protected $withCount = ['seasons', 'podcasts'];


    // relationships

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }

    public function podcasts(): HasMany
    {
        return $this->hasMany(Podcast::class);
    }

    public function scopeWithOwnerInfo(Builder $query)
    {
        return $query->with([
            'owner' => function ($q) {
                $q->select('id', 'name', 'profile_img')
                    ->with(['category' => fn($q) => $q->withoutGlobalScopes()->select('categories.id', 'categories.name')]);
            }
        ]);

    }
}
