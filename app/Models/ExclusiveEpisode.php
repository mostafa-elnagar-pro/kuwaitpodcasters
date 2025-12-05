<?php

namespace App\Models;

use App\Traits\PodcastSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExclusiveEpisode extends Model
{
    use HasFactory, PodcastSearchable;

    protected $fillable = [
        'season_id',
        'user_id',
        'channel_id',
        'name',
        'image',
        'description',
        'media_type', /* video | audio */
        'media_source', /* link | fileupload */
        'link',
    ];


    public function podcaster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}

