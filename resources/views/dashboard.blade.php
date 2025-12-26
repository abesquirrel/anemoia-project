@extends('layouts.admin')

@section('content')
    {{-- Redirect Admin to Admin Dashboard (Optional, but cleaner to just show links) --}}
    @if(auth()->user()->is_admin)
        <script>window.location = "{{ route('admin.dashboard') }}";</script>
    @endif

    <div class="text-center mt-5">
        <h1 class="h2 text-gray-900 mb-4">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="lead text-gray-600 mb-5">Explore the latest updates from Anem[o]ia.</p>

        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 py-4 border-left-primary transition-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-images fa-3x text-primary mb-3"></i>
                        <h4 class="font-weight-bold">View Galleries</h4>
                        <p class="text-muted">Browse our latest photography collections.</p>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary stretched-link">Explore Galleries</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 py-4 border-left-info transition-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-book-open fa-3x text-info mb-3"></i>
                        <h4 class="font-weight-bold">Read the Blog</h4>
                        <p class="text-muted">Catch up on our latest stories and articles.</p>
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-info stretched-link">Go to Blog</a>
                    </div>
                </div>
            </div>
            
             <div class="col-md-4 mb-4">
                <div class="card shadow h-100 py-4 border-left-secondary transition-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-user-cog fa-3x text-secondary mb-3"></i>
                        <h4 class="font-weight-bold">My Profile</h4>
                        <p class="text-muted">Update your account settings.</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary stretched-link">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
