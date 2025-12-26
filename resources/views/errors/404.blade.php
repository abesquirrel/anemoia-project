@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center p-5 card shadow-sm" style="max-width: 600px; border: 1px solid var(--border-color);">
        <h1 class="display-1 font-weight-bold" style="color: var(--accent-primary);">404</h1>
        <h3 class="mb-4" style="color: var(--text-main);">Page Not Found</h3>
        <p class="lead mb-5" style="color: var(--text-muted);">
            The page you are looking for does not exist or has been moved.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2">
            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
        </a>
    </div>
</div>
@endsection
