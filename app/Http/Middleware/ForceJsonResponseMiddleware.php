<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->header('Accept', 'application/json');
        
        return $next($request);
    }
}
