@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center p-5 card shadow-sm" style="max-width: 600px; border: 1px solid var(--border-color);">
        <div class="mb-4">
             <i class="fas fa-exclamation-triangle fa-4x mb-3" style="color: var(--accent-primary); opacity: 0.8;"></i>
        </div>
        <h1 class="font-weight-bold mb-4" style="color: var(--text-main);">System Error</h1>
        <div class="my-4 p-3 text-left" style="background-color: var(--bg-hover); border-radius: 4px; color: var(--text-muted); font-family: monospace;">
            <p class="mb-1">Code: 500</p>
            <p class="mb-0">Status: Internal Server Error</p>
        </div>
         <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-redo mr-2"></i> Reload Dashboard
        </a>
    </div>
</div>
@endsection
