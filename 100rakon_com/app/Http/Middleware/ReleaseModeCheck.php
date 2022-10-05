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
        //모드에 따라 허용된 IP인지 확인 : 개발은 개발끼리, 라이브는 라이브 끼리
        if(env("APP_ENV") == 'dev')
        {
            //허용된 IP가 아닌경우
            $allowIps = explode('|', env("APP_ARROW_IP"));
            if(!in_array($_SERVER['REMOTE_ADDR'], $allowIps))
            {
                return response('ACCESS NOT READY');
            }
        }
        return $next($request);
    }
}
