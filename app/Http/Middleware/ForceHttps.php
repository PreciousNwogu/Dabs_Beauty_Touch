<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
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
        // Force HTTPS in production, but handle proxy scenarios
        if (config('app.env') === 'production') {
            $isSecure = $request->secure() || 
                       $request->header('X-Forwarded-Proto') === 'https' ||
                       $request->header('X-Forwarded-Ssl') === 'on';
            
            // Only redirect if we're definitely not secure and not already handling HTTPS
            if (!$isSecure && !$request->header('X-Forwarded-Proto')) {
                return redirect()->secure($request->getRequestUri(), 301);
            }
        }

        $response = $next($request);

        // Add security headers in production
        if (config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        }

        return $response;
    }
}
