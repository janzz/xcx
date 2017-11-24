<?php

namespace App\Http\Middleware;

use Closure;

class LoginAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return !session('adminInfo') ? redirect('/login'): $next($request);
    }
}
