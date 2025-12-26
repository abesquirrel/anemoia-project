@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('home') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-external-link-alt fa-sm text-white-50 mr-2"></i>View Website
        </a>
    </div>

    {{-- STATS ROW --}}
    <div class="row">

        {{-- Galleries --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Galleries</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $galleryCount }}</div>
                            <div class="mt-2 mb-0 text-xs text-muted">
                                <span class="text-success mr-2"><i class="fas fa-eye"></i> {{ $galleryVisible }}</span>
                                <span class="text-secondary"><i class="fas fa-eye-slash"></i> {{ $galleryHidden }}</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-images fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Blog Posts --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Blog Posts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postCount }}</div>
                            <div class="mt-2 mb-0 text-xs text-muted">
                                <span class="text-success mr-2"><i class="fas fa-check-circle"></i> {{ $postPublished }}</span>
                                <span class="text-secondary"><i class="fas fa-pen-nib"></i> {{ $postDraft }}</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pen-square fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Photos --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Photos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $photoCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-camera fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT ROW --}}
    <div class="row">

        {{-- Recent Activity --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                    <a href="{{ route('admin.activity_log.index') }}" class="small font-weight-bold">View All</a>
                </div>
                <div class="card-body">
                    @if($recentLogs->count() > 0)
                        {{-- Use the proper .timeline class from custom.css --}}
                        <div class="timeline">
                            @foreach($recentLogs as $log)
                                @php
                                    // Reuse simplified logic for dashboard styling
                                    $iconClass = match ($log->event_type) {
                                        'login', 'user_logged_in' => 'success',
                                        'logout' => 'warning',
                                        'login_failed', 'suspicious_access' => 'danger',
                                        'registration', 'profile_updated', 'user_profile' => 'info',
                                        default => 'primary'
                                    };
                                    $icon = match ($log->event_type) {
                                        'login', 'user_logged_in' => 'fa-sign-in-alt',
                                        'logout' => 'fa-sign-out-alt',
                                        'registration', 'user_created' => 'fa-user-plus',
                                        default => 'fa-info'
                                    };
                                @endphp
                                <div class="timeline-item">
                                    <div class="timeline-marker {{ $iconClass }}">
                                        <i class="fas {{ $icon }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="small text-gray-500 mb-1">{{ $log->created_at->diffForHumans() }}</div>
                                        <h6 class="font-weight-bold mb-1 text-dark">
                                            {{ ucfirst(str_replace('_', ' ', $log->event_type)) }}
                                        </h6>
                                        <p class="mb-0 text-sm text-secondary">
                                            {{ $log->message }} 
                                        </p>
                                        {{-- Only show user line if user exists --}}
                                        @if($log->user)
                                            <div class="mt-1 small text-muted font-italic">
                                                <i class="fas fa-user-circle mr-1"></i> {{ $log->user->name }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center my-4">No recent activity.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-block mb-3">
                        <i class="fas fa-plus mr-2"></i> Create New Gallery
                    </a>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-info btn-block mb-3">
                        <i class="fas fa-pen mr-2"></i> Write Blog Post
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus mr-2"></i> Add New User
                    </a>
                </div>
            </div>

            {{-- System Status --}}
             <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Info</h6>
                </div>
                <div class="card-body">
                    <div class="small mb-2">
                        <span class="font-weight-bold">PHP Version:</span> {{ phpversion() }}
                    </div>
                    <div class="small mb-2">
                        <span class="font-weight-bold">Laravel:</span> {{ app()->version() }}
                    </div>
                    <div class="small">
                         <span class="font-weight-bold">Server Time:</span> {{ now()->format('Y-m-d H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
