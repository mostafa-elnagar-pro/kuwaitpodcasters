<?php

namespace App\Http\Controllers\Website;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        try {
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();

            return responseWithData($notification->data);
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of __invoke */

}