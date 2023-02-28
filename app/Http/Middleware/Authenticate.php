<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        // Check token
//        $jwtAuth = app(JWTAuth::class)->setRequest($request)->parseToken();

        try {
            $token = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            // Token invalid or not provided
            return response()->json([
                'error' => 'Unauthenticated',
            ], 401);
        }

        // Check token expiration
        $expiresAt = $token->expires_at;
        $now = now();

        if ($now->gt($expiresAt)) {
            // Token expired
            return response()->json([
                'error' => 'Token expired',
            ], 401);
        }

        return $next($request);
    }
}
