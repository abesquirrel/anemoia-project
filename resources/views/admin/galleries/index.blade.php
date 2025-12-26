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
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light">
                                    <tr>
                                        <th style="width: 100px;">Cover</th>
                                        <th>Title</th>
                                        <th style="width: 10%;">Visible</th>
                                        <th style="width: 10%;">Count</th>
                                        <th style="width: 15%;">Created</th>
                                        <th style="width: 25%;">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($galleries as $gallery)
                                        <tr>
                                            <td>
                                                <div class="rounded overflow-hidden shadow-sm" style="width: 80px; height: 60px;">
                                                    <img src="{{ $gallery->cover_photo_url }}" alt="{{ $gallery->title }}" class="w-100 h-100" style="object-fit: cover;">
                                                </div>
                                            </td>
                                            <td class="font-weight-bold text-dark">{{ $gallery->title }}</td>
                                            <td>
                                                @if($gallery->is_visible)
                                                    <span class="badge badge-pill badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-pill badge-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $gallery->photos_count }}</td>
                                            <td>{{ $gallery->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('admin.photos.index', $gallery) }}" class="btn btn-sm btn-info btn-circle mr-1" title="Manage Photos">
                                                        <i class="fas fa-images"></i>
                                                    </a>
                                                    <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-primary btn-circle mr-1" title="Edit Gallery">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    
                                                    @if($gallery->featured_at)
                                                        <form action="{{ route('admin.galleries.unfeature', $gallery) }}" method="POST" class="d-inline mr-1">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-warning btn-circle" title="Unfeature">
                                                                <i class="fas fa-star"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.galleries.feature', $gallery) }}" method="POST" class="d-inline mr-1">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-secondary btn-circle" title="Feature">
                                                                <i class="far fa-star"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger btn-circle" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">No galleries found. Create one!</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile Card View (< md) --}}
                            <div class="d-md-none">
                                @forelse ($galleries as $gallery)
                                    <div class="card mb-4 overflow-hidden border-0 shadow">
                                        <!-- Cover Image Header -->
                                        <div style="height: 160px; overflow: hidden; position: relative;">
                                            <img src="{{ $gallery->cover_photo_url }}" class="w-100" style="position: absolute; top: 50%; transform: translateY(-50%); width: 100%; min-height: 100%; object-fit: cover;">
                                            <div class="position-absolute bottom-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                                 <h5 class="text-white font-weight-bold mb-0">{{ $gallery->title }}</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div>
                                                     @if($gallery->is_visible)
                                                        <span class="badge badge-success">Visible</span>
                                                    @else
                                                        <span class="badge badge-secondary">Hidden</span>
                                                    @endif
                                                    @if($gallery->featured_at)
                                                        <span class="badge badge-warning">Featured</span>
                                                    @endif
                                                </div>
                                                <span class="text-muted small"><i class="fas fa-camera mr-1"></i> {{ $gallery->photos_count }} Photos</span>
                                            </div>
                                            
                                            <div class="btn-group w-100 shadow-sm">
                                               <a href="{{ route('admin.photos.index', $gallery) }}" class="btn btn-white border"><i class="fas fa-images text-info"></i></a>
                                               <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-white border"><i class="fas fa-edit text-primary"></i></a>
                                                @if($gallery->featured_at)
                                                    <form action="{{ route('admin.galleries.unfeature', $gallery) }}" method="POST" class="d-inline flex-fill">
                                                        @csrf @method('PATCH')
                                                        <button class="btn btn-white w-100 border text-warning"><i class="fas fa-star"></i></button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.galleries.feature', $gallery) }}" method="POST" class="d-inline flex-fill">
                                                        @csrf @method('PATCH')
                                                        <button class="btn btn-white w-100 border text-secondary"><i class="far fa-star"></i></button>
                                                    </form>
                                                @endif
                                               <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline flex-fill" onsubmit="return confirm('Are you sure?');">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-white w-100 border text-danger"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center p-3">
                                        <p class="text-muted">No galleries found.</p>
                                    </div>
                                @endforelse
                            </div>
        </div>
    </div>
@endsection
