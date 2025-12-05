<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\EventLog; // *** REQUIRED: Import the EventLog model ***
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $email = $this->input('email');
        $ipAddress = $this->ip();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            // --- LOGGING FAILED CREDENTIALS ---
            try {
                EventLog::create([
                    'event_type' => 'login_failed',
                    'message' => 'Login attempt failed for email: ' . $email . ' (Incorrect credentials).',
                    'ip_address' => $ipAddress,
                    'user_agent' => $this->userAgent(),
                    'user_id' => null, // User ID is unknown/unauthenticated
                ]);
            } catch (\Exception $e) {
                Log::error('EventLog FAILED logging failed login attempt: ' . $e->getMessage());
            }
            // ----------------------------------

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        // --- LOGGING SUCCESSFUL LOGIN ---
        try {
            // Note: Auth::attempt sets the authenticated user in the request object
            $user = Auth::user();

            EventLog::create([
                'event_type' => 'user_logged_in',
                'message' => 'User ID ' . $user->id . ' logged in successfully.',
                'ip_address' => $ipAddress,
                'user_agent' => $this->userAgent(),
                'user_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            Log::error('EventLog FAILED logging successful login: ' . $e->getMessage());
        }
        // --------------------------------
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $email = $this->input('email');
        $ipAddress = $this->ip();

        event(new Lockout($this));

        // --- LOGGING RATE-LIMITED ATTEMPT ---
        try {
            EventLog::create([
                'event_type' => 'login_rate_limited',
                'message' => 'Login attempt rate-limited for email: ' . $email . ' (Throttle key: ' . $this->throttleKey() . ').',
                'ip_address' => $ipAddress,
                'user_agent' => $this->userAgent(),
                'user_id' => null,
            ]);
        } catch (\Exception $e) {
            Log::error('EventLog FAILED logging rate-limited login: ' . $e->getMessage());
        }
        // ------------------------------------

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
