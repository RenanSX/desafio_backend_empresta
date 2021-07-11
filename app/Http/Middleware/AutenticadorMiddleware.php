<?php

namespace App\Http\Middleware;

use Closure;

class AutenticadorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(str_replace('Basic ', '', $request->header('Authorization')) === env('MY_TOKEN')) {
            return $next($request);
        } else {
            return response('Unauthorized.', 401);
            //OR return redirect()->guest('/');
        }
    }
}
