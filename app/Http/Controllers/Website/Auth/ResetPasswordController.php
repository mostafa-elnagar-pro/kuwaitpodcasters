<?php

namespace App\Http\Controllers\Website\Auth;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ResetPasswordRequest;
use App\Mail\PasswordReset;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('website.auth.forgot-password');
    }
    /**end of showForgotPasswordForm*/

    public function sendOTP(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();

            $otp = rand(10000, 99999);

            PasswordResetToken::updateOrCreate(
                ['email' => $user->email],
                ['token' => $otp, 'created_at' => now()]
            );

            defer(fn() => Mail::to($user->email)->send(new PasswordReset($otp)));

            return to_route('website.reset-pwd.form', [
                'email' => $user->email
            ])->with('success', __kw('otp_email_sent', 'OTP sent!'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e);
        }
    }
    /**end of sendOTP */


    public function showResetPasswordForm(Request $request)
    {
        return view('website.auth.reset-password', [
            'email' => $request->email
        ]);
    }
    /**end of showResetPasswordForm */


    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();

            $record = PasswordResetToken::with('user')->where(['email' => $data['email'], 'token' => $data['otp']])->first();
            if (!$record || $record->created_at->addMinutes(30)->isPast()) {
                return back()->with('error', __kw('invalid_otp', 'invalid OTP'));
            }

            $record->user->update(['password' => bcrypt($data['password'])]);

            $record->delete();

            return to_route('website.showLoginForm')
                ->with('success', __kw('pwd_updated', 'Updated password successfully'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e);
        }
    }
    /**end of resetPassword */
}
