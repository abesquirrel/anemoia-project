<?php

namespace App\Observers;

use App\Models\User;
use App\Models\EventLog;

class UserObserver
{
    /**
     * Handle the User "created" event.
     * (Handled by Registered event mainly, but good backup for manual creates)
     */
    public function created(User $user): void
    {
        if (!request()->routeIs('register')) { // Avoid double logging with Registered event
            EventLog::create([
                'event_type' => 'user_created',
                'message' => 'User created: ' . $user->name . ' by ' . (auth()->user() ? auth()->user()->name : 'System'),
                'user_id' => auth()->id(), // Admin who created it
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Logic to describe what changed
        $changes = $user->getChanges();
        unset($changes['updated_at']); // Ignore timestamp update

        if (empty($changes)) return;

        $msg = 'User profile updated. Changed: ' . implode(', ', array_keys($changes));

        EventLog::create([
            'event_type' => 'user_updated',
            'message' => $msg,
            'user_id' => auth()->id() ?? $user->id, // If admin changed it, log admin ID. If user changed self, log their ID
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        EventLog::create([
            'event_type' => 'user_deleted',
            'message' => 'User deleted: ' . $user->name,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
