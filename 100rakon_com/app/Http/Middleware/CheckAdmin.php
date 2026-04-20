<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */

    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('login');
        }

        if($user->super !== 'Y') {
            abort(403);
        }

        return $next($request);
    }
}
