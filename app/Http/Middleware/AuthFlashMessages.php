<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthFlashMessages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the response
        $response = $next($request);
        
        // Check if user just logged in
        if ($request->is('login') && $request->isMethod('post') && Auth::check()) {
            session()->flash('status', 'login-success');
        }
        
        // Check if user just registered
        if ($request->is('register') && $request->isMethod('post') && Auth::check()) {
            session()->flash('status', 'registration-success');
        }
        
        // Check if login failed
        if ($request->is('login') && $request->isMethod('post') && !Auth::check() && $response->getStatusCode() === 302) {
            session()->flash('status', 'auth-failed');
        }
        
        return $response;
    }
}
