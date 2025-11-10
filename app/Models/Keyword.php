<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Keyword extends Model
{
    use HasFactory, HasTranslations, Searchable;

    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'type'
    ];


    protected $translatable = [
        'value'
    ];


    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }
}
