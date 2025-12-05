@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Activity Log</h1>

        <style>
            /* --- FIX: Constrain the size of oversized SVG icons in pagination --- */
            /* This targets the SVG elements often used for 'Previous'/'Next' arrows. */
            .pagination svg {
                width: 1rem;
                height: 1rem;
                vertical-align: middle;
            }
        </style>

        {{--
            NOTE ON DOUBLE PAGINATION: If you see double pagination, you likely need
            to configure Laravel to use the Bootstrap pagination view instead of the
            default Tailwind view.

            Fix: Add the following line to the boot() method of AppServiceProvider.php:
            \Illuminate\Pagination\Paginator::useBootstrapFive();
        --}}

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
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
                {{ $logs->links('pagination::bootstrap-5') }}            </div>
        </div>
    </div>
@endsection
