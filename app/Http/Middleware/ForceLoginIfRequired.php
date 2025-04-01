<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Brij Negi Update
class ForceLoginIfRequired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if login is forced for this page
       // if ($request->route()->parameter('forceLogin') === 'yes' && !auth()->check()) {
        if ($request->route()->parameter('forceLogin') === 'yes' && !session()->has('UserViewer')) {
            // Redirect or return a response to show the login/register popup
            return response()->view('auth.popup'); // Replace with your modal or logic
        }

        return $next($request);
    }
}
