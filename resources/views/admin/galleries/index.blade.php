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

            <div class="table-responsive">
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
                            <td>
                                <a href="{{ route('admin.photos.index', $gallery) }}" class="btn btn-info btn-sm">Photos</a>
                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-warning btn-sm">Edit</a>
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
        </div>
    </div>
@endsection
