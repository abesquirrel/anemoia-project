@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Galleries</h1>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm">
            + New Gallery
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th style="width: 10%;">Visible</th>
                                        <th style="width: 10%;">Photo Count</th>
                                        <th style="width: 15%;">Created</th>
                                        <th style="width: 25%;">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($galleries as $gallery)
                                        <tr>
                                            <td>{{ $gallery->title }}</td>
                                            <td>
                                                @if($gallery->is_visible)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $gallery->photos_count }}</td>
                                            <td>{{ $gallery->created_at->format('Y-m-d') }}</td>
                                            <td style="min-width: 300px;">
                                                <a href="{{ route('admin.photos.index', $gallery) }}" class="btn btn-info btn-sm">Photos</a>
                                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-warning btn-sm">Edit</a>
                                                @if($gallery->featured_at)
                                                    <form action="{{ route('admin.galleries.unfeature', $gallery) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-secondary btn-sm">Unfeature</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.galleries.feature', $gallery) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-primary btn-sm">Feature</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No galleries found. Create one!</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile Card View (< md) --}}
                            <div class="d-md-none">
                                @forelse ($galleries as $gallery)
                                    <div class="card mb-3 border-left-primary shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="card-title font-weight-bold text-primary mb-0">{{ $gallery->title }}</h5>
                                                @if($gallery->is_visible)
                                                    <span class="badge bg-success">Visible</span>
                                                @else
                                                    <span class="badge bg-secondary">Hidden</span>
                                                @endif
                                            </div>
                                            <p class="card-text small text-muted mb-2">
                                                Created: {{ $gallery->created_at->format('M d, Y') }} &bull;
                                                {{ $gallery->photos_count }} Photos
                                            </p>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('admin.photos.index', $gallery) }}" class="btn btn-info btn-sm mb-1 flex-grow-1">Photos</a>
                                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-warning btn-sm mb-1 flex-grow-1">Edit</a>

                                                @if($gallery->featured_at)
                                                    <form action="{{ route('admin.galleries.unfeature', $gallery) }}" method="POST" class="d-inline mb-1 flex-grow-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="w-100 btn btn-secondary btn-sm">Unfeature</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.galleries.feature', $gallery) }}" method="POST" class="d-inline mb-1 flex-grow-1">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="w-100 btn btn-primary btn-sm">Feature</button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline mb-1 flex-grow-1" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-100 btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center p-3">
                                        <p class="text-muted">No galleries found. Create one!</p>
                                    </div>
                                @endforelse
                            </div>
        </div>
    </div>
@endsection
