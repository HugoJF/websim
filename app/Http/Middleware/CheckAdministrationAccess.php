<?php

namespace App\Http\Middleware;

use Closure;
use Gate;

class CheckAdministrationAccess
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
        if(Gate::denies('access-administration')) {
            return redirect('/');
        } else {
            return $next($request);
        }
    }
}
