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
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                    <tr>
                        <th style="width: 100px;">Cover</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($posts as $post)
                        @php
                            $coverUrl = $post->featured_image ? Storage::url($post->featured_image) : ($post->coverPhoto ? Storage::url($post->coverPhoto->filename) : null);
                        @endphp
                        <tr>
                            <td>
                                <div class="rounded overflow-hidden shadow-sm bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                                    @if($coverUrl)
                                        <img src="{{ $coverUrl }}" alt="{{ $post->title }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <i class="fas fa-newspaper text-gray-400 fa-lg"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="font-weight-bold text-dark">{{ $post->title }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>
                                @if($post->published_at && $post->published_at <= now())
                                    <span class="badge badge-pill badge-success px-2">Published</span>
                                @else
                                    <span class="badge badge-pill badge-secondary px-2">Draft</span>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No posts found. Create one!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View (< md) --}}
            <div class="d-md-none">
                @forelse ($posts as $post)
                    @php
                        $coverUrl = $post->featured_image ? Storage::url($post->featured_image) : ($post->coverPhoto ? Storage::url($post->coverPhoto->filename) : null);
                    @endphp
                    <div class="card mb-4 overflow-hidden border-0 shadow">
                         @if($coverUrl)
                            <div style="height: 160px; overflow: hidden; position: relative;">
                                <img src="{{ $coverUrl }}" class="w-100" style="position: absolute; top: 50%; transform: translateY(-50%); width: 100%; min-height: 100%; object-fit: cover;">
                                <div class="position-absolute bottom-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                     <h5 class="text-white font-weight-bold mb-0">{{ $post->title }}</h5>
                                </div>
                            </div>
                        @endif
                        <div class="card-body">
                             @if(!$coverUrl)
                                <h5 class="card-title font-weight-bold text-primary">{{ $post->title }}</h5>
                             @endif
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    @if($post->published_at && $post->published_at <= now())
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-secondary">Draft</span>
                                    @endif
                                </div>
                                <span class="text-muted small">By {{ $post->user->name }}</span>
                            </div>
                            <p class="card-text small text-muted mb-3">
                                Created on {{ $post->created_at->format('M d, Y') }}
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-warning w-100">Edit <i class="fas fa-edit ml-1"></i></a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-100 btn btn-outline-danger">Delete <i class="fas fa-trash ml-1"></i></button>
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
