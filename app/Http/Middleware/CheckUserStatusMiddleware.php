<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserStatusMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->status_id === 2) {
            return redirect()->back()->with('error', 'Your account is banned');
        }

        return $next($request);
    }
}
