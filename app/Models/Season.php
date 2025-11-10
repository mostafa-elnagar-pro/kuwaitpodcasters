<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Season extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'channel_id'
    ];


    protected $withCount= ['podcasts'];


    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function podcasts(): HasMany
    {
        return $this->hasMany(Podcast::class);
    }
}
