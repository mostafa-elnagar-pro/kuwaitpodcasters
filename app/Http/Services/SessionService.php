<?php

namespace App\Http\Services;


use Illuminate\Support\Facades\Cookie;

class SessionService
{
    public static function store($user)
    {
        $token = $user->createToken('podcaster_session')->plainTextToken;

        return cookie("podcaster_session", $token, 60 * 24 * 30 * 12);
    }

    public static function restore($user)
    {
        $user->tokens()->where('tokenable_id', $user->id)->delete();
        Cookie::forget("podcaster_session");

        $token = $user->createToken('podcaster_session')->plainTextToken;

        return cookie("podcaster_session", $token, 60 * 24 * 30 * 12);
    }

    public static function kill($user)
    {
        Cookie::forget("podcaster_session");

        $user->tokens()->where('tokenable_id', $user->id)->delete();

        return true;
    }
}
