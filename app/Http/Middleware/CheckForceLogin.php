<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// Brij Negi Update
class CheckForceLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if `forceLogin` is required
        if ($request->route()->parameter('forceLogin') === 'yes' && !session()->has('UserViewer')) {
            return response()->view('auth.popup'); // Replace with your modal or redirect logic
        }

        return $next($request);
    }
}
