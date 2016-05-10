<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App;

class Offline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
        	if (!isset($_SESSION['lang']))
        	{
        		$_SESSION['lang'] = 'en';
        	}
        	App::setLocale($_SESSION['lang']);
        }
        else
        {
        	App::setLocale(strtolower(Auth::user()->getLangue()));
        }

        return $next($request);
    }
}
