<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        Activity::saving(function (Activity $activity) {
            if (Auth::guard('admin')->check()) {
                $activity->causer_type = \App\Models\Admin::class;
                $activity->causer_id = Auth::guard('admin')->id();
            } elseif (Auth::guard('web')->check()) {
                $activity->causer_type = \App\Models\User::class;
                $activity->causer_id = Auth::guard('web')->id();
            }
        });
    }
}
