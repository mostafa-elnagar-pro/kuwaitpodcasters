<?php

namespace App\Http\Controllers\Website\Auth;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Services\SessionService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('website.auth.login');
    }


    public function login(Request $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);

            $user = User::where('email', $credentials['email'])->firstOrFail();

            if ($user->type === 'podcaster') {
                return back()->with('error', __('messages.error'));
            }

            // if ($user->type === 'podcaster' && $user->status !== 'active') {
            //     return back()->with('error', __('messages.contactSupport'));
            // }

            if (!Auth::attempt(credentials: $credentials)) {
                return back()->with('error', __('messages.failedLogin'));
            }

            return redirect()->intended(route('website.index'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedLogin'));
        }
    }
    /**end of login */
}
