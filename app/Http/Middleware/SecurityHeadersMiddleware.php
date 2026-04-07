<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeadersMiddleware
{
    public function handle($request, Closure $next)
{
    $response = $next($request);

    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
    $response->headers->set('Permissions-Policy', "geolocation=(), microphone=()");

    // CSP sem quebras de linha !!!
    $response->headers->set('Content-Security-Policy',
"default-src 'self'; img-src 'self' data: blob https://maps.gstatic.com; script-src 'self' https://maps.googleapis.com https://maps.gstatic.com; style-src 'self' 'unsafe-inline'; font-src 'self'; frame-src https://www.google.com https://maps.googleapis.com; child-src https://www.google.com https://maps.googleapis.com; connect-src 'self';"
    );

    return $response;
}


}
