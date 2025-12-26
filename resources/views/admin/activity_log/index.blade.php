@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Activity Log</h1>

        {{--
            NOTE ON DOUBLE PAGINATION: If you see double pagination, you likely need
            to configure Laravel to use the Bootstrap pagination view instead of the
            default Tailwind view.
        --}}

        {{-- Timeline View --}}
        <div class="timeline">
            @foreach($logs as $log)
                @php
                    // Determine style/icon based on event type
                    $style = match ($log->event_type) {
                        'login_failed', 'password_update_failed', 'login_rate_limited', 'suspicious_access' => ['class' => 'danger', 'icon' => 'fa-exclamation-triangle'],
                        'account_deleted', 'photo_deleted', 'gallery_deleted' => ['class' => 'secondary', 'icon' => 'fa-trash'],
                        'user_logged_in', 'password_updated' => ['class' => 'success', 'icon' => 'fa-check'],
                        'profile_updated', 'user_profile' => ['class' => 'info', 'icon' => 'fa-user-edit'],
                        default => ['class' => 'primary', 'icon' => 'fa-info'], // Generic
                    };
                    $badgeDetails = $style; // Reuse logic
                @endphp

                <div class="timeline-item">
                    <div class="timeline-marker {{ $style['class'] }}">
                        <i class="fas {{ $style['icon'] }}"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="card shadow-sm {{ $style['class'] }}">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="font-weight-bold text-gray-800 mb-0">
                                        {{ str_replace('_', ' ', Str::title($log->event_type)) }}
                                    </h6>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-2 text-dark">{{ $log->message }}</p>
                                <div class="d-flex align-items-center small text-muted">
                                    <span class="mr-3">
                                        <i class="fas fa-user mr-1"></i> 
                                        {{ $log->user ? $log->user->name : 'System/Guest' }}
                                    </span>
                                    <span><i class="fas fa-network-wired mr-1"></i> {{ $log->ip_address }}</span>
                                    <span class="ml-auto d-none d-sm-inline">{{ $log->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
             {{ $logs->links() }}
        </div>
    </div>
    </div>
@endsection
