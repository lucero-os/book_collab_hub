<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class ValidateJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the token is provided in the Authorization header
        $token = $request->bearerToken();

        if (!$token) {
            // No token provided, unauthorized
            throw new AuthenticationException();
        }

        try {
            if (!auth('api')->user()) {
                // Token is invalid or expired
                throw new AuthenticationException('Token is invalid or expired');
            }
        } catch (JWTException $e) {
            throw new AuthenticationException('Token is invalid or expired');
        }

        // Everything is fine, pass the request further
        return $next($request);
    }
}