<?php

namespace App\Http\Middleware;

use Closure;

class Asociacion
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
        if($request->user()->id_ro===2)
            return $next($request);
        else
            return redirect(route('home'));
    }
}
