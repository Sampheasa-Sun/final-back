<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            Cache::put('user-is-online-' . Auth::id(), true, now()->addMinutes(5));
        }

        if (Auth::guard('admin')->check()) {
            Cache::put('admin-is-online-' . Auth::guard('admin')->id(), true, now()->addMinutes(5));
        }

        return $next($request);
    }
}
