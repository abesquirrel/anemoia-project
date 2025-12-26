@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh; font-family: 'Courier New', Courier, monospace;">
    <div class="text-center p-5" style="background-color: #002b36; color: #839496; border: 1px solid #586e75; box-shadow: 0 0 20px rgba(0,0,0,0.5); max-width: 600px;">
        <h1 style="font-size: 5rem; color: #dc322f; font-weight: bold; font-family: sans-serif;">ERROR 500</h1>
        <h3 class="mb-4" style="color: #b58900;">System Malfunction</h3>
        <p class="mb-4" style="font-family: monospace; color: #2aa198;">
            > DETECTED INTERNAL FAULT<br>
            > INITIATING RECOVERY PROTOCOLS...<br>
            > PLEASE STAND BY.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg" style="border-radius: 0; color: #002b36; font-weight: bold;">
            <i class="fas fa-power-off mr-2"></i> Reboot / Home
        </a>
    </div>
</div>
@endsection
