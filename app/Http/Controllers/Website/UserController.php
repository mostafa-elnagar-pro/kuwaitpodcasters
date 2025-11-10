<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('website.users.index', );
    }
    /**end of index */

    public function show(User $user)
    {
        return view('website.users.show', [
            'user'=> $user
        ]);
    }
    /**end of show */
}
