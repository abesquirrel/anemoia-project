<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger">Delete Account</h6>
    </div>
    <div class="card-body">
        <p class="text-muted small">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            Delete Account
        </button>

        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Are you sure you want to delete your account?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                            <div class="mb-3">
                                <label for="password_delete" class="form-label font-weight-bold text-gray-800">Password</label>
                                <input id="password_delete" name="password" type="password" class="form-control" required placeholder="Password">
                                @if($errors->userDeletion->get('password'))
                                    <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
