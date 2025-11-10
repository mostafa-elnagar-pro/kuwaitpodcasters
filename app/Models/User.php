<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Searchable;
use App\Traits\Followable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        HasApiTokens,
        Searchable,
        Followable;

    protected $fillable = [
        'type',
        'name',
        'email',
        'country_id',
        'phone',
        'password',
        'profile_img',
        'fcm_token',
        'status'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function podcasterDetails(): HasOne
    {
        return $this->hasOne(PodcasterDetails::class);
    }

    public function category()
    {
        return $this->hasOneThrough(Category::class, PodcasterDetails::class, 'user_id', 'id', 'id', 'category_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function channel(): HasOne
    {
        return $this->hasOne(Channel::class);
    }

    public function podcasts(): HasMany
    {
        return $this->hasMany(Podcast::class);
    }

    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Podcast::class, 'podcast_likes')->withTimestamps();
    }


    public function hasLiked($podcast_id): bool
    {
        return $this->favourites()->where('podcast_id', $podcast_id)->exists();
    }


    public function appRate(): HasOne
    {
        return $this->hasOne(AppRate::class);
    }


    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }


    public function comment(): HasOne
    {
        return $this->hasOne(PodcastComment::class);
    }

}
