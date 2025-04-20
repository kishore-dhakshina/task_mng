<?php

namespace App\Exceptions;

use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    // Other methods...

    /**
     * Handle an unauthenticated user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof TokenExpiredException) {
                return response()->json(['error' => 'Token expired. Please log in again.'], 401);
            } elseif ($exception instanceof TokenInvalidException) {
                return response()->json(['error' => 'Invalid token. Please log in again.'], 401);
            } else {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }

        // Fallback for non-API requests, redirecting to login page
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    // Other methods...
}
