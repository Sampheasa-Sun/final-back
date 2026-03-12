<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Always redirect to admin login for all protected areas
            if (
                $request->is('admin') ||
                $request->is('admin/*') ||
                $request->is('dashboard') ||
                $request->is('dashboard/*') ||
                $request->is('articles') ||
                $request->is('articles/*') ||
                $request->is('manage_user') ||
                $request->is('admin_setting')
            ) {
                return route('admin.login');
            }

            // Optional: redirect everything else to admin login too
            return route('admin.login');
        }

        return null;
    }
}
