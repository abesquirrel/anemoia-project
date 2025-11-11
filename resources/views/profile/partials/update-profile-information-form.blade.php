<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
    </div>
    <div class="card-body">
        <p class="text-muted small">Update your account's profile information and email address.</p>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label font-weight-bold text-gray-800">Name</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                @if($errors->get('name'))
                    <div class="text-danger small mt-1">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="email" class="form-label font-weight-bold text-gray-800">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @if($errors->get('email'))
                    <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                @endif

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="small text-warning">
                            Your email address is unverified.
                            <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                                Click here to re-send the verification email.
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="small text-success">
                                A new verification link has been sent to your email address.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-4">
                <button type="submit" class="btn btn-primary">Save</button>
                @if (session('status') === 'profile-updated')
                    <span class="text-success small">Saved.</span>
                @endif
            </div>
        </form>

        {{-- This form is for the 're-send' button --}}
        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
            @csrf
        </form>
    </div>
</div>
