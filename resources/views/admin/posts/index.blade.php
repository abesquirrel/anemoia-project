@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Blog Posts</h1>
        @if(auth()->user()->is_admin)
            <a href="{{ route('admin.posts.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-2"></i>New Post
            </a>
        @else
            <div class="alert alert-info shadow-sm border-left-info" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-edit fa-lg mr-3"></i>
                    <div>
                        <strong>Editor Mode Protected:</strong><br>
                        You can edit existing posts, but cannot create or delete them.
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Error/Success Alerts --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- DESKTOP VIEW --}}
    <div class="card shadow mb-4 d-none d-md-block">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Posts</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Image</th>
                        <th width="30%">Title</th>
                        <th width="15%">Author</th>
                        <th width="15%">Last Editor</th>
                        <th width="10%">Status</th>
                        <th width="15%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>
                                @if($post->featured_image)
                                    <img src="{{ $post->featured_image_url }}" alt="Thumbnail" class="img-fluid rounded" style="max-height: 50px;">
                                @else
                                    <div class="bg-gray-200 text-gray-400 rounded d-flex align-items-center justify-content-center" style="height: 50px; width: 50px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="font-weight-bold text-primary">
                                    {{ $post->title }}
                                </a>
                                <div class="small text-muted">{{ Str::limit($post->body, 50) }}</div>
                            </td>
                            <td>
                                {{ $post->user->name }}
                            </td>
                            <td>
                                @if($post->editor)
                                    <span class="badge badge-light border">
                                        {{ $post->editor->name }}
                                    </span>
                                    <div class="text-xs text-muted">{{ $post->updated_at->diffForHumans() }}</div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($post->published_at && $post->published_at <= now())
                                    <span class="badge badge-success">Published</span>
                                @elseif($post->published_at && $post->published_at > now())
                                    <span class="badge badge-warning">Scheduled</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-info btn-circle" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                @if(auth()->user()->is_admin)
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-circle" onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary btn-circle" title="Admins Only" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No posts found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MOBILE VIEW Cards --}}
    <div class="d-md-none">
        @foreach($posts as $post)
            <div class="card shadow mb-3">
                 @if($post->featured_image)
                    <div style="height: 150px; overflow: hidden; border-radius: 0.75rem 0.75rem 0 0;">
                         <img src="{{ $post->featured_image_url }}" class="w-100" style="object-fit: cover; height: 100%;">
                    </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        @if($post->published_at && $post->published_at <= now())
                            <span class="badge badge-success">Published</span>
                        @else
                            <span class="badge badge-secondary">Draft</span>
                        @endif
                         <small class="text-muted">{{ $post->updated_at->format('M d, Y') }}</small>
                    </div>
                    
                    <h5 class="font-weight-bold text-gray-900 mb-1">{{ $post->title }}</h5>
                    <p class="small text-gray-600 mb-3">
                         By {{ $post->user->name }}
                        @if($post->editor)
                             <br><span class="text-xs text-muted">Edited by {{ $post->editor->name }}</span>
                        @endif
                    </p>

                    <div class="d-flex justify-content-end">
                         <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-info btn-sm mr-2">
                            <i class="fas fa-pen mr-1"></i> Edit
                        </a>
                        @if(auth()->user()->is_admin)
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this post?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
