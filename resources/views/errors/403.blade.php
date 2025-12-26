@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh; font-family: 'Courier New', Courier, monospace;">
    <div class="text-center p-5 shadow-lg" style="background-color: #eee8d5; border: 4px double #cb4b16; max-width: 600px;">
        <div class="mb-3">
             <i class="fas fa-hand-paper fa-5x" style="color: #cb4b16; opacity: 0.6;"></i>
        </div>
        <h1 style="font-size: 4rem; color: #cb4b16; text-transform: uppercase;">Restricted</h1>
        <h3 class="mb-4" style="color: #586e75;">Access Denied</h3>
        <p class="lead mb-4" style="color: #657b83;">
            "You do not have the necessary clearance to view this dossier."
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-danger btn-lg" style="border-radius: 0; text-transform: uppercase; font-weight: bold; font-family: sans-serif;">
            <i class="fas fa-arrow-left mr-2"></i> Back to Safety
        </a>
    </div>
</div>
@endsection
