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
     *
     * @noinspection PhpParamsInspection*/
    public function boot(): void
    {
//        // Listen for Failed Logins
//        Event::listen(function (Failed $event) {
//            EventLog::create([
//                'event_type' => 'security_alert',
//                'message'    => 'Failed login attempt for email: ' . $event->credentials['email'],
//                'ip_address' => request()->ip(),
//                'user_agent' => request()->userAgent(),
//            ]);
//        });
    }
}
