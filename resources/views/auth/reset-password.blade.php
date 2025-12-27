@extends('layouts.site')

@section('content')

    <style>
        /* Shared Authentication Styles */
        .login-masthead {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 700px;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.8) 75%, #000000 100%), url('{{ asset('assets/img/bg-masthead.webp') }}');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.9);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 10;
        }

        .form-control-dark {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e5e5;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control-dark:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #64a19d;
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(100, 161, 157, 0.25);
        }

        .auth-title {
            font-family: "Varela Round", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            letter-spacing: 4px;
            color: white;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .auth-subtitle {
            text-align: center;
            color: rgba(255,255,255,0.6);
            font-size: 0.85rem;
            margin-bottom: 2.5rem;
            font-weight: 300;
        }

        .form-label {
            font-size: 0.75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.7);
            margin-bottom: 0.5rem;
        }
    </style>

    <header class="login-masthead">
        <div class="container px-4">

            <div class="d-flex justify-content-center">
                <div class="login-card fade-in-up">

                    <h1 class="auth-title">New Password</h1>
                    <p class="auth-subtitle">Secure your memories</p>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" class="form-control form-control-dark rounded-1"
                                   type="email" name="email" value="{{ old('email', $request->email) }}"
                                   required autofocus autocomplete="username">
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control form-control-dark rounded-1"
                                   type="password" name="password"
                                   required autocomplete="new-password">
                            @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" class="form-control form-control-dark rounded-1"
                                   type="password" name="password_confirmation"
                                   required autocomplete="new-password">
                            @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 text-uppercase fw-bold"
                                    style="letter-spacing: 2px; font-size: 0.85rem; border-radius: 2px;">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </header>

@endsection
