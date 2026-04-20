<?php

namespace App\Http\Middleware;

use Closure;

class ReleaseModeCheck
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
        if(app()->environment('dev')) {
            $allowIps = config('app.allow_ips', ['127.0.0.1', '::1']);

            if(!in_array($request->ip(), $allowIps, true)) {
                return response('ACCESS NOT READY');
            }
        }
        return $next($request);
    }
}
