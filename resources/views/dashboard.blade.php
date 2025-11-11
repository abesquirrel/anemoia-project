@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Welcome!</h6>
        </div>
        <div class="card-body">
            <p>You're logged in!</p>

            @if(auth()->user()->is_admin)
                <p>You are an administrator.</p>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-primary">
                    Go to Admin Panel
                </a>
            @endif
        </div>
    </div>
@endsection
