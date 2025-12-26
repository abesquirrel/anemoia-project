@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Blog Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
            + New Post
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
                        <th>Author</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>
                                @if($post->published_at && $post->published_at <= now())
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td style="width: 15%;">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No posts found. Create one!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View (< md) --}}
            <div class="d-md-none">
                @forelse ($posts as $post)
                    <div class="card mb-3 border-left-primary shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title font-weight-bold text-primary mb-0">{{ $post->title }}</h5>
                                @if($post->published_at && $post->published_at <= now())
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </div>
                            <p class="card-text small text-muted mb-2">
                                By {{ $post->user->name }} &bull; {{ $post->created_at->format('M d, Y') }}
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning btn-sm flex-grow-1">Edit</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-100 btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-3">
                        <p class="text-muted">No posts found. Create one!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
