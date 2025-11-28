<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // Prevents clickjacking
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // Prevents MIME sniffing
        $response->headers->set('X-XSS-Protection', '1; mode=block'); // Prevents XSS attacks
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin'); // Prevents referrer leakage

        return $response;
    }
}
