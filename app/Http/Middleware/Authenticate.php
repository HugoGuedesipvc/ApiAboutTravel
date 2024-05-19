<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Throwable;

class Authenticate extends Middleware
{
    public function handle($request, $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return $next($request);
    }
}
