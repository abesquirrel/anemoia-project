<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        // and if their 'is_admin' flag is set to true.
        if (!auth()->check() || !auth()->user()->is_admin) {
            // If not, redirect to the home page.
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
