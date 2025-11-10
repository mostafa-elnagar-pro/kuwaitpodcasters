<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Services\SessionService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke()
    {
        try {
            $user = auth()->user();

            SessionService::kill($user);

            $user->update(["fcm_token" => null]);

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
}
