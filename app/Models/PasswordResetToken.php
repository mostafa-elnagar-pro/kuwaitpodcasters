<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = "password_reset_tokens";

    protected $primaryKey = 'email';

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];


    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
