@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Activity Log</h1>

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
                                <span class="badge {{ $log->event_type == 'security_alert' || $log->event_type == 'suspicious_access' ? 'bg-danger' : ($log->event_type == 'click' ? 'bg-info' : 'bg-primary') }}">
                                    {{ $log->event_type }}
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
                {{ $logs->links() }} {{-- Pagination links --}}
            </div>
        </div>
    </div>
@endsection
