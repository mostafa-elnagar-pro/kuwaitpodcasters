<?php

namespace App\Helpers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExceptionHandler
{
    public static function api(\Throwable $e, string|null $customError = null)
    {
        if ($e instanceof ValidationException) {
            return errorResponse($e->validator->errors()->first());
        } elseif ($e instanceof QueryException) {
            if ($e->errorInfo[1] == 1451) {
                return errorResponse(__('messages.parentRecordError'));
            }
        } elseif ($e instanceof AuthorizationException) {
            return errorResponse(__('messages.unauthorizedAction'));
        } elseif ($e instanceof ModelNotFoundException) {
            return errorResponse(__('messages.notFound'), Response::HTTP_NOT_FOUND);
        }

        return errorResponse($customError ?? __('messages.error'));
    }
    /**end of api */



    public static function panel(\Throwable $e, string|null $customError = null)
    {
        if ($e instanceof QueryException) {
            if ($e->errorInfo[1] === 1451) {
                return back()->with('error', __('messages.parentRecordError'));
            }
        } elseif ($e instanceof ValidationException) {
            return back()->with('errors', $e->validator->errors());
        }

        return back()->with('error', $customError ?? __('messages.error'));
    }
    /**end of panel */
}
