@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center p-5 card shadow-sm" style="max-width: 600px; border-left: 5px solid var(--accent-primary);">
        <h1 class="font-weight-bold text-uppercase mb-3" style="color: var(--text-main);">Access Denied</h1>
        <h2 class="h5 mb-4 font-italic" style="color: var(--accent-primary);">403 Forbidden</h2>
        
        <p class="lead mb-4" style="color: var(--text-muted); font-family: monospace;">
            > PERMISSION: MISSING<br>
            > USER: {{ auth()->check() ? auth()->user()->name : 'GUEST' }}
        </p>
        
        <p class="mb-5" style="color: var(--text-main);">
            You do not have permission to view this resource.
        </p>

        <a href="{{ route('dashboard') }}" class="btn btn-link" style="color: var(--accent-primary);">
            &larr; Return Home
        </a>
    </div>
</div>
@endsection
