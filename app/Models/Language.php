<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Language extends Model
{
    use HasFactory, HasTranslations;


    protected $fillable = [
        'name',
        'abbr',
        'flag',
        'direction',
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

}
