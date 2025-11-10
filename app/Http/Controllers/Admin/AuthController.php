<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.pages.auth.login');
    }
    /**end of showLoginForm */


    public function login(AdminLoginRequest $request)
    {
        try {
            $credentials = $request->validated();

            if (!Auth::guard('admin')->attempt($credentials)) {
                return back()->with('error', __('messages.failedLogin'));
            }

            $user = auth('admin')->user();

            return redirect()->intended(
                $user->isAbleTo('home-read') ? route('admin.home') : "admins/$user->id"
            );
        } catch (\Exception $e) {
            return back()->with('error', __('messages.failedLogin'));
        }
    }
    /**end of login */


    public function logout()
    {
        try {
            Auth::guard('admin')->logout();

            return to_route('admin.login.show');
        } catch (\Exception $e) {
            return back()->with('error', __('messages.failedLogout'));
        }
    }
    /**end of logout */
}
