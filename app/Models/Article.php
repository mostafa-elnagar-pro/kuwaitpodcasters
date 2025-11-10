<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasFactory, HasTranslations;


    protected $fillable = [
        'title',
        'short_body',
        'body',
        'image',
    ];



    protected $translatable = [
        'title',
        'short_body',
        'body'
    ];


    protected function casts(): array
    {
        return [
            'title' => 'array',
            'short_body' => 'array',
            'body' => 'array',
        ];
    }

}
