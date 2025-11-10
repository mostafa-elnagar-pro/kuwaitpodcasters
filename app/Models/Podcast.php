<?php

namespace App\Models;

use App\Models\Scopes\ActivePodcastScope;
use App\Traits\PodcastSearchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Podcast extends Model
{
    use PodcastSearchable;

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
        'duration',
        'is_active'
    ];



    protected static function booted()
    {
        static::addGlobalScope(new ActivePodcastScope());
    }


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


    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'podcast_likes')->withTimestamps();
    }

    public function views(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'podcast_views')->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PodcastComment::class, 'podcast_id');
    }

    public function viewedBy($user_id): bool
    {
        return $this->views()->where('user_id', $user_id)->exists();
    }

    // scopes
    public function scopeWithStats($query)
    {
        return $query->withCount('likes', 'views')
            ->withExists([
                'likes as in_favourites' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ]);
    }


    public function scopeWithPodcasterInfo(Builder $query)
    {
        return $query->with([
            'podcaster' => function ($q) {
                return $q->select('id', 'name', 'profile_img')
                    ->with(['category' => fn($q) => $q->select('categories.id', 'categories.name')]);
            }
        ]);
    }


    public function scopeMostViewed(Builder $query)
    {
        return $query->leftJoin('podcast_views', 'podcasts.id', '=', 'podcast_views.podcast_id')
            ->select('podcasts.*', DB::raw('COUNT(podcast_views.id) as total_views'))
            ->groupBy('podcasts.id')
            ->orderByDesc('total_views');
    }

}
