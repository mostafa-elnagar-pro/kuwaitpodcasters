<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Mail\PasswordReset;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    private $OTP_EXPIRE_AFTER = 30;

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

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of sendOTP */


    public function verifyOTP(Request $request)
    {
        try {
            $record = PasswordResetToken::where([
                'email' => $request->email,
                'token' => $request->otp
            ])->first();

            if (!$record) {
                return errorResponse(__('messages.invalidOTP'));
            }

            if ($record->created_at->addMinutes($this->OTP_EXPIRE_AFTER)->isPast()) {
                return errorResponse(__('messages.expiredOTP'));
            }

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of verifyOTP */


    public function resetPWD(ResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();

            $record = PasswordResetToken::with('user')->where([
                'email' => $data['email'],
                'token' => $data['otp']
            ])->first();

            if (!$record) {
                return errorResponse(__('messages.invalidOTP'));
            }

            if ($record->created_at->addMinutes($this->OTP_EXPIRE_AFTER)->isPast()) {
                return errorResponse(__('messages.expiredOTP'));
            }

            $record->user->update([
                'password' => bcrypt($data['new_password'])
            ]);

            $record->delete();

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of resetPWD */

}
