<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfSuperAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_if(
            $request->role->id === 1,
            401,
            __('messages.notAllowedToUpdateOrDeleteSuperAdminRole')
        );

        return $next($request);
    }
}
