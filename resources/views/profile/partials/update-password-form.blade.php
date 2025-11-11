<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Update Password</h6>
    </div>
    <div class="card-body">
        <p class="text-muted small">Ensure your account is using a long, random password to stay secure.</p>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="current_password" class="form-label font-weight-bold text-gray-800">Current Password</label>
                <input id="current_password" name="current_password" type="password" class="form-control" required>
                @if($errors->updatePassword->get('current_password'))
                    <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="password" class="form-label font-weight-bold text-gray-800">New Password</label>
                <input id="password" name="password" type="password" class="form-control" required>
                @if($errors->updatePassword->get('password'))
                    <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label font-weight-bold text-gray-800">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                @if($errors->updatePassword->get('password_confirmation'))
                    <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-4">
                <button type="submit" class="btn btn-primary">Save</button>
                @if (session('status') === 'password-updated')
                    <span class="text-success small">Saved.</span>
                @endif
            </div>
        </form>
    </div>
</div>
