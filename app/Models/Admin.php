<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable implements LaratrustUser
{
    use HasFactory, HasRolesAndPermissions;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        "password"
    ];
}
