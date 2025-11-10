<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PodcasterDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'bio',
        'facebook',
        'youtube',
        'instagram',
        'twitter',
        'snapchat',
        'tiktok',
        'linkedin'
    ];



    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
