@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Manage Photos</h1>
            <p class="mb-0 text-muted small">Gallery: <span class="font-weight-bold text-primary">{{ $gallery->title }}</span></p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-3 shadow-sm border-left-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mb-3 shadow-sm border-left-danger">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Upload Zone --}}
    <div class="card shadow mb-4 border-0">
        <div class="card-body p-0">
            <form action="{{ route('admin.photos.store', $gallery) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="position-relative text-center p-5 rounded" style="border: 2px dashed #d1d3e2; background: #f8f9fc; transition: all 0.3s ease;" ondragover="this.style.background='#eaecf4'; this.style.borderColor='#4e73df';" ondragleave="this.style.background='#f8f9fc'; this.style.borderColor='#d1d3e2';">
                    
                    <input class="position-absolute w-100 h-100 top-0 left-0" style="opacity: 0; cursor: pointer; z-index: 10;" type="file" id="photos" name="photos[]" multiple required onchange="document.getElementById('file-chosen-text').innerText = this.files.length + ' file(s) ready to upload'">
                    
                    <div style="pointer-events: none;">
                        <i class="fas fa-cloud-upload-alt fa-3x text-gray-400 mb-3"></i>
                        <h5 class="text-gray-700 font-weight-bold">Drop photos here or click to upload</h5>
                        <p class="text-gray-500 small mb-2">High resolution JPG/PNG supported</p>
                        <div id="file-chosen-text" class="text-primary font-weight-bold mt-2" style="min-height: 24px;"></div>
                    </div>

                    {{-- Optional Metadata --}}
                    <div class="mt-4 mx-auto" style="max-width: 400px; position: relative; z-index: 20;">
                        <input type="text" class="form-control form-control-sm text-center border-0 bg-white shadow-sm" id="exif_metadata" name="exif_metadata" placeholder="Optional: Batch label (e.g. 'Kodak Gold 200')">
                    </div>

                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2 mt-3 shadow-sm position-relative" style="z-index: 20;">
                        <i class="fas fa-upload mr-2"></i> Start Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Photo Grid --}}
    <div class="row no-gutters">
        @forelse ($gallery->photos as $photo)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 p-1">
                <div class="rounded overflow-hidden shadow-sm photo-item-container bg-dark h-100 d-flex flex-column">
                    
                    {{-- The Image --}}
                    <div class="position-relative flex-grow-1" style="overflow: hidden;">
                        <img src="{{ $photo->url }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover; min-height: 150px; {{ !$photo->is_visible ? 'filter: grayscale(100%); opacity: 0.6;' : '' }} {{ $photo->is_cover_photo ? 'border: 3px solid #f6c23e;' : '' }}"
                             alt="Photo">

                        {{-- Status Badges (Over Image) --}}
                        @if($photo->is_cover_photo)
                            <div class="position-absolute top-0 left-0 p-1">
                                <span class="badge badge-warning text-dark shadow-sm"><i class="fas fa-star"></i></span>
                            </div>
                        @endif
                        
                        @if(!$photo->is_visible)
                            <div class="position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="fas fa-eye-slash fa-2x text-white shadow-text"></i>
                            </div>
                        @endif
                    </div>

                    {{-- DEDICATED DARK TOOLBAR (Always Visible) --}}
                    <div class="d-flex justify-content-between align-items-center px-2 py-2" style="background: #1a1c23; border-top: 1px solid #2c303b;">
                         
                        {{-- Make Cover --}}
                        @if(!$photo->is_cover_photo)
                            <form action="{{ route('admin.photos.setCover', $photo) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-link text-secondary p-0 hover-yellow" title="Set as Cover">
                                    <i class="far fa-star"></i>
                                </button>
                            </form>
                        @else
                            <div class="text-warning" title="Cover Photo">
                                <i class="fas fa-star"></i>
                            </div> 
                        @endif

                        {{-- Metadata --}}
                        <div class="small text-muted mx-2 text-truncate" style="max-width: 80px; font-size: 0.7rem;">
                            {{ $photo->exif_metadata ?? '-' }}
                        </div>

                        {{-- Right Side Actions --}}
                        <div class="d-flex align-items-center">
                            {{-- Visibility --}}
                            <form action="{{ route('admin.photos.toggleVisibility', $photo) }}" method="POST" class="mr-2">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-link {{ $photo->is_visible ? 'text-secondary' : 'text-danger' }} p-0 hover-blue" title="Toggle Visibility">
                                    <i class="fas {{ $photo->is_visible ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                </button>
                            </form>

                            {{-- Delete --}}
                            <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Permanently delete this photo?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-link text-secondary p-0 hover-red" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center text-muted">
                <i class="fas fa-images fa-3x mb-3 text-gray-300"></i>
                <p>No photos in this gallery yet.</p>
            </div>
        @endforelse
    </div>

    <style>
        .hover-yellow:hover { color: #f6c23e !important; }
        .hover-blue:hover { color: #36b9cc !important; }
        .hover-red:hover { color: #e74a3b !important; }
        .shadow-text { text-shadow: 0 2px 4px rgba(0,0,0,0.8); }
    </style>
@endsection
