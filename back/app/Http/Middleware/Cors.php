<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Cors
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
        header('Access-Control-Allow-Origin: ' . (env('APP_ENV') == 'production' ? env('FRONT_APP_URL') : '*'));
        header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Authorization, Origin');
        header('Access-Control-Allow-Methods: *');
        return $next($request);
    }
}
