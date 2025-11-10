<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __invoke()
    {
        try {
            $notifications = auth()->user()->notifications()->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $notifications,
                NotificationResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of index */
}
