<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Failed;
use App\Models\EventLog;

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
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Register User Observer
        \App\Models\User::observe(\App\Observers\UserObserver::class);

        // Register Auth Listeners
        // Note: Listeners are auto-discovered in Laravel 11+ or via EventServiceProvider in older versions.
        // If duplicates appear, these lines are likely the cause.
        // Event::listen(\Illuminate\Auth\Events\Login::class, \App\Listeners\LogSuccessfulLogin::class);
        // Event::listen(\Illuminate\Auth\Events\Logout::class, \App\Listeners\LogLogout::class);
        // Event::listen(\Illuminate\Auth\Events\Registered::class, \App\Listeners\LogUserRegistration::class);
    }
}
