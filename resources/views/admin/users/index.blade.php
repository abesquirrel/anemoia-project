@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Users</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i>New User
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger mb-3">{{ session('error') }}</div>
            @endif

            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                    <tr>
                        <th style="width: 60px;">Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white font-weight-bold" style="width: 40px; height: 40px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            </td>
                            <td class="font-weight-bold text-dark">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge badge-pill badge-danger px-2">Admin</span>
                                @else
                                    <span class="badge badge-pill badge-secondary px-2">User</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info btn-circle" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-circle" onclick="return confirm('Are you sure? This cannot be undone.')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No users found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View (< md) --}}
            <div class="d-md-none">
                @forelse ($users as $user)
                    <div class="card mb-3 shadow-sm border-left-{{ $user->is_admin ? 'danger' : 'secondary' }}">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white font-weight-bold mr-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="card-title font-weight-bold text-dark mb-0">{{ $user->name }}</h5>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @if($user->is_admin)
                                        <span class="badge badge-danger">Administrator</span>
                                    @else
                                        <span class="badge badge-secondary">Standard User</span>
                                    @endif
                                </div>
                                <span class="text-muted small">Joined {{ $user->created_at->format('M Y') }}</span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning w-100">Edit</a>
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-100 btn btn-outline-danger">Delete</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-3">
                        <p class="text-muted">No users found.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
