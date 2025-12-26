<?php

namespace App\Listeners;

use App\Models\EventLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        EventLog::create([
            'event_type' => 'login',
            'message' => 'User logged in successfully.',
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => $event->user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
