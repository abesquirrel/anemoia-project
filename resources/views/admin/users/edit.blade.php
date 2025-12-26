@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit User: <span class="fw-light">{{ $user->name }}</span></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- LEFT COLUMN: Main Info --}}
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Account Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label font-weight-bold">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label font-weight-bold">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Change Password (Optional)</h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning small mb-3">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Leave blank to keep current password.
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label font-weight-bold">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label font-weight-bold">Confirm New Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: Roles & Actions --}}
                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Permissions</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-bold" for="is_admin">
                                        Grant Admin Access
                                    </label>
                                </div>

                                <div class="alert alert-info small">
                                    Created: {{ $user->created_at->format('M d, Y') }}
                                </div>

                                <hr>
                                
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    <i class="fas fa-save mr-2"></i> Update User
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-block text-secondary border">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
