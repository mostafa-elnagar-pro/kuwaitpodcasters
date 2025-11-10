<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Enums\NotificationType;
use App\Http\Services\FcmService;
use App\Helpers\ExceptionHandler;
use App\Models\User;

class NotifyUserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:users-read', only: ['index', 'show']),
            new Middleware('permission:users-create', only: ['create', 'store']),
            new Middleware(['permission:users-update'], only: ['edit', 'update']),
            new Middleware(['permission:users-delete'], only: ['destroy', 'bulkDelete']),
        ];
    }
    /**end of middleware */


    public function notify(Request $request, User $user)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'body' => 'required|string',
                'link' => 'nullable|string'
            ]);

            if (is_null($user->fcm_token)) {
                throw new \Error('error');
            }

            /** notification logic */
            defer(function () use ($request, $user) {
                FcmService::notify(
                    receiver: $user,
                    title: $request->title,
                    body: $request->body,
                    data: [
                        'type' => NotificationType::ADMIN_MESSAGE,
                        'image' => displayFile(null),
                        'link' => $request->link,
                    ]
                );
            });
            /** end of notification logic */

            return back()
                ->with('success', __('messages.successNotify'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedNotify'));
        }
    }
    /**end of notify */


    public function notifyAll(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|in:all,user,podcaster',
                'title' => 'required|string',
                'body' => 'required|string',
                'link' => 'nullable|string',
            ]);

            $query = User::select('id', 'fcm_token');
            if ($request->type !== 'all') {
                $query->where('type', $request->type);
            }
            $notifiables = $query->whereNotNull('fcm_token')->get();

            defer(function () use ($request, $notifiables) {
                foreach ($notifiables as $notifiable) {
                    /** notification logic */
                    FcmService::notify(
                        receiver: $notifiable,
                        title: $request->title,
                        body: $request->body,
                        data: [
                            'type' => NotificationType::ADMIN_MESSAGE,
                            'image' => displayFile(null),
                            'link' => $request->link,
                        ]
                    );
                    /** end of notification logic */
                }
            });

            return back()
                ->with('success', __('messages.successNotify'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedNotify'));
        }
    }
    /**end of NotifyUserByType */
}
