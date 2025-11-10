<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PodcastComment extends Model
{
    protected $table = 'podcast_comments';

    protected $fillable = [
        'podcast_id',
        'user_id',
        'comment'
    ];


    public function podcast(): BelongsTo
    {
        return $this->belongsTo(Podcast::class, 'podcast_id');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
