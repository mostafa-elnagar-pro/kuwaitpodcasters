<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Services\SessionService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = User::with(['podcasterDetails.category', 'channel'])
                ->where('email', $request->email)
                ->orWhere('phone', $request->phone)
                ->firstOrFail();

            if ($user->type === 'podcaster' && $user->status !== 'active') {
                return errorResponse(__('messages.contactSupport'));
            }

            $isCorrectPwd = Hash::check($request->password, $user->password);
            if (!$isCorrectPwd) {
                return errorResponse(__('messages.invalidCredentials'));
            }

            $user->update(['fcm_token' => $request->device_token ?? null]);

            $cookie = SessionService::restore($user);

            return authResponseWithData(
                new UserResource($user),
                $cookie
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e, __('messages.failedLogin'));
        }
    }
    /**end of login */
}
