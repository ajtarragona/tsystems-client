<?php

namespace Ajtarragona\Tsystems\Middlewares;

use Closure;

class TsystemsBackend
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
    	if (!config("tsystems.backend")) {
    		 $error=__("Oops! TSystems backend is disabled");
    		 return view("tsystems::error",compact('error'));
        }

        return $next($request);
    }
}