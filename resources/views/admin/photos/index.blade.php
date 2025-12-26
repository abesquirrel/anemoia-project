@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Photos: <span class="fw-light">{{ $gallery->title }}</span></h1>
        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary btn-sm">
            &larr; Back to Galleries
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Upload New Photos</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.photos.store', $gallery) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="custom-file-upload-area mb-3">
                    <label for="photos" style="cursor: pointer; width: 100%;">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <h5 class="text-white">Tap to Select Photos</h5>
                        <p class="text-gray-500 small mb-0">Multiple selection supported</p>
                        <input class="form-control d-none" type="file" id="photos" name="photos[]" multiple required onchange="document.getElementById('file-chosen-text').innerText = this.files.length + ' file(s) selected'">
                    </label>
                    <div id="file-chosen-text" class="text-success mt-2 font-weight-bold"></div>
                </div>
                
                <div class="mb-3">
                    <label for="exif_metadata" class="form-label">Batch Metadata (Optional)</label>
                    <input type="text" class="form-control" id="exif_metadata" name="exif_metadata" placeholder="e.g. 'Kodak Gold 200'">
                </div>
                
                <button type="submit" class="btn btn-primary btn-block py-3 font-weight-bold">
                    <i class="fas fa-upload mr-2"></i> Upload Photos
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Existing Photos ({{ $gallery->photos->count() }})</h6>
        </div>

        <div class="card-body">
            <div class="row g-3">
                @forelse ($gallery->photos as $photo)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">

                        {{-- Card Container --}}
                        <div class="card h-100 shadow-sm {{ !$photo->is_visible ? 'border-warning bg-light' : '' }}">

                            {{-- Image Container --}}
                            <div class="position-relative" style="aspect-ratio: 1/1; overflow: hidden;">
                                <img src="{{ $photo->url }}"
                                     class="card-img-top w-100 h-100"
                                     style="object-fit: cover; {{ !$photo->is_visible ? 'opacity: 0.5; filter: grayscale(100%);' : '' }}"
                                     alt="Photo">

                                {{-- Cover Badge --}}
                                @if($photo->is_cover_photo)
                                    <div class="position-absolute top-0 start-0 p-1">
                                        <span class="badge bg-warning text-dark border border-white shadow-sm">
                                            <i class="fas fa-star"></i> Cover
                                        </span>
                                    </div>
                                @endif

                                {{-- Hidden Badge --}}
                                @if(!$photo->is_visible)
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <span class="badge bg-dark shadow"><i class="fas fa-eye-slash"></i> Hidden</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions Toolbar --}}
                            <div class="card-footer p-2 bg-white d-flex justify-content-between align-items-center">

                                {{-- Make Cover --}}
                                @if(!$photo->is_cover_photo)
                                    <form action="{{ route('admin.photos.setCover', $photo) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-link btn-sm text-warning p-0" title="Set as Cover">
                                            <i class="far fa-star fa-lg"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-link btn-sm text-warning p-0" disabled>
                                        <i class="fas fa-star fa-lg"></i>
                                    </button>
                                @endif

                                {{-- Toggle Visibility --}}
                                <form action="{{ route('admin.photos.toggleVisibility', $photo) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-link btn-sm {{ $photo->is_visible ? 'text-secondary' : 'text-dark' }} p-0" title="Toggle Visibility">
                                        <i class="fas {{ $photo->is_visible ? 'fa-eye' : 'fa-eye-slash' }} fa-lg"></i>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Delete this photo?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-sm text-danger p-0" title="Delete">
                                        <i class="fas fa-trash-alt fa-lg"></i>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="fas fa-images fa-3x mb-3 text-gray-300"></i>
                        <p>No photos uploaded yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
