<?php

namespace Modules\LuxeTemplate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Brij Negi Update
class ForceLoginIfRequired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
