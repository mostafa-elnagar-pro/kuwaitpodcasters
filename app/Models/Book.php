<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Book extends Model
{
    use HasFactory, HasTranslations;


    protected $fillable = [
        'name',
        'author',
        'summary',
        'publication_year',
        'publisher',
    ];



    protected $translatable = [
        'name',
        'author',
        'summary',
        'publisher'
    ];


    protected function casts(): array
    {
        return [
            'name' => 'array',
            'author' => 'array',
            'summary' => 'array',
            'publisher' => 'array',
        ];
    }

}

