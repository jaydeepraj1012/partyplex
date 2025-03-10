<?php

namespace App\Http\Middleware;

use App\Events\UserStatusChanged;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackUserOnlineStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            
            // Update user's online status
            if (!$user->is_online) {
                $user->is_online = true;
                $user->last_seen = now();
                $user->save();
                
                // Broadcast status change
                broadcast(new UserStatusChanged($user, 'online'));
            }
            
            // Update last seen time every 5 minutes
            if ($user->last_seen === null || now()->diffInMinutes($user->last_seen) >= 5) {
                $user->last_seen = now();
                $user->save();
            }
        }
        
        return $next($request);
    }
}
