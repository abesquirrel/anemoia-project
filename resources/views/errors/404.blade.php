@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh; font-family: 'Courier New', Courier, monospace;">
    <div class="text-center p-5 shadow-lg" style="background-color: #fdf6e3; border: 2px dashed #d6d6d6; transform: rotate(-1deg); max-width: 600px;">
        <h1 style="font-size: 6rem; color: #b58900; opacity: 0.8; text-shadow: 2px 2px 0px rgba(0,0,0,0.1);">404</h1>
        <h3 class="mb-4" style="color: #657b83; text-transform: uppercase; letter-spacing: 2px;">Missing Page</h3>
        <p class="lead mb-4" style="color: #586e75;">
            "We apologize for the inconvenience, but the page you requested cannot be found in our archives."
        </p>
        <hr style="border-color: #93a1a1; margin: 2rem auto; width: 50%;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark btn-lg" style="border-radius: 0; text-transform: uppercase; font-weight: bold; font-family: sans-serif;">
            <i class="fas fa-undo mr-2"></i> Return Home
        </a>
    </div>
</div>
@endsection
