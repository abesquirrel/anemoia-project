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

        // 1. HSTS (Force HTTPS for 1 year)
        // Only applies if request is secure, or we can force it always if we are behind a proxy.
        // For local dev, we might not see the effect, but good for prod.
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // 2. Anti-Clickjacking & XSS
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 3. Permissions Policy (Privacy)
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // 4. Content Security Policy (CSP) - strict rules for scripts/styles
        // Allow: Self, Google Fonts, FontAwesome, GLightbox (JSDelivr), Google Analytics
        $csp = "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://use.fontawesome.com https://cdn.jsdelivr.net https://www.googletagmanager.com; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://use.fontawesome.com https://cdn.jsdelivr.net; " .
            "font-src 'self' https://fonts.gstatic.com https://use.fontawesome.com; " .
            "img-src 'self' data: https://ui-avatars.com; " .
            "connect-src 'self' https://www.google-analytics.com;";

        // Note: 'unsafe-inline' and 'unsafe-eval' are often needed for Alpine/Livewire or inline scripts.
        // We included them to prevent breakage, but can be tightened later with nonces.

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
