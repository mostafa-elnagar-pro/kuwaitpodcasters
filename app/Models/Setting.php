<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasFactory, HasTranslations;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'key',
        'value',
        'trans_value',
        'note'
    ];


    protected $translatable = [
        'trans_value',
    ];


    protected function casts(): array
    {
        return [
            'trans_value' => 'array',
        ];
    }


    public function getTranslatedValue(string $key, string $locale)
    {
        return $this->getTranslation('trans_value', $locale)[$key] ?? null;
    }    
}
