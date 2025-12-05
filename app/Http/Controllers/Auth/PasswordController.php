<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EventLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @throws ValidationException
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // --- 1. Manual Check for Current Password (Logging Failed Attempts) ---
        // We temporarily validate the new password fields first, ignoring current_password.
        try {
            $request->validate([
                'current_password' => ['required', 'string'], // Check presence, but skip 'current_password' rule
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            $currentPassword = $request->input('current_password');

            if (!Hash::check($currentPassword, $user->password)) {
                // Password check failed (User entered incorrect current password)

                // Log the FAILURE attempt
                try {
                    EventLog::create([
                        'event_type' => 'password_update_failed',
                        'message' => 'User ID ' . $user->id . ' failed to update password: Incorrect current password provided.',
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'user_id' => $user->id,
                    ]);
                } catch (\Exception $e) {
                    Log::error('EventLog FAILED logging password failure: ' . $e->getMessage());
                }

                // Manually throw the validation exception for the framework to handle the redirect/error message
                throw ValidationException::withMessages([
                    'current_password' => __('The provided current password does not match our records.'),
                ]);
            }

        } catch (ValidationException $e) {
            // Re-throw any ValidationException (e.g., new password doesn't meet requirements)
            throw $e;
        }

        // 2. Hash and save the new password (Only reached if the manual Hash::check passed)
        $validated = $request->only('password'); // Get only the new password field

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 3. ADD THE SUCCESS LOGGING HERE
        try {
            EventLog::create([
                'event_type' => 'password_updated',
                'message' => 'User ID ' . $user->id . ' successfully changed their password.',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => $user->id,
            ]);

        } catch (\Exception $e) {
            // Log database error silently, but do not interrupt the redirect
            Log::error('EventLog Creation FAILED for password update (User ID: ' . $user->id . '): ' . $e->getMessage());
        }

        // 4. Redirect or respond
        // This is the CRITICAL line that ensures a RedirectResponse is returned.
        return back()->with('status', 'password-updated');
    }
}
