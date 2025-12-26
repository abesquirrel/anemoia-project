@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Activity Log</h1>

        {{--
            NOTE ON DOUBLE PAGINATION: If you see double pagination, you likely need
            to configure Laravel to use the Bootstrap pagination view instead of the
            default Tailwind view.
        --}}

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Message</th>
                            <th>User ID</th>
                            <th>IP Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @php
                                        // Define Bootstrap badge classes based on event type for clarity
                                        $badgeClass = match ($log->event_type) {
                                            'login_failed', 'password_update_failed', 'login_rate_limited' => 'bg-danger', // Security/Failure events
                                            'account_deleted' => 'bg-secondary', // Deletion
                                            'user_logged_in', 'password_updated' => 'bg-success', // Success/Critical
                                            'profile_updated', 'user_profile' => 'bg-info', // Standard update/info
                                            'click', 'gallery_link_click', 'button_click' => 'bg-warning text-dark', // User activity/low priority
                                            default => 'bg-primary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ str_replace('_', ' ', Str::title($log->event_type)) }}
                                    </span>
                                </td>
                                <td>{{ $log->message }}</td>
                                <td>{{ $log->user_id ?? 'Guest' }}</td>
                                <td>{{ $log->ip_address }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card View (< md) --}}
                <div class="d-md-none">
                    @foreach($logs as $log)
                        <div class="card mb-3 shadow-sm border-left-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">{{ $log->created_at->format('M d, H:i') }}</small>
                                    @php
                                        $badgeClass = match ($log->event_type) {
                                            'login_failed', 'password_update_failed', 'login_rate_limited' => 'bg-danger',
                                            'account_deleted' => 'bg-secondary',
                                            'user_logged_in', 'password_updated' => 'bg-success',
                                            'profile_updated', 'user_profile' => 'bg-info',
                                            'click', 'gallery_link_click', 'button_click' => 'bg-warning text-dark',
                                            default => 'bg-primary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ str_replace('_', ' ', Str::title($log->event_type)) }}
                                    </span>
                                </div>
                                <p class="mb-1 font-weight-bold">{{ $log->message }}</p>
                                <div class="small text-monospace text-muted mt-2">
                                    <i class="fas fa-user col-1 pl-0"></i> {{ $log->user_id ?? 'Guest' }}<br>
                                    <i class="fas fa-network-wired col-1 pl-0"></i> {{ $log->ip_address }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
