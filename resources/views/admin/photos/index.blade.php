@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Photos for: <span class="fw-light">{{ $gallery->title }}</span></h1>
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
                <div class="mb-3">
                    <label for="photos" class="form-label">Select Photos (multiple allowed)</label>
                    <input class="form-control" type="file" id="photos" name="photos[]" multiple required>
                </div>
                <div class="mb-3">
                    <label for="exif_metadata" class="form-label">Metadata (e.g., "Kodak Gold 200")</label>
                    <input type="text" class="form-control" id="exif_metadata" name="exif_metadata" placeholder="Optional: Applied to all uploaded photos">
                </div>
                <button type="submit" class="btn btn-primary">Upload Photos</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Existing Photos ({{ $gallery->photos->count() }})</h6>
        </div>
        <div class="card-body">
            <div class="row gx-3 gy-3">
                @forelse ($gallery->photos as $photo)
                    <div class="col-md-3">
                        <div class="card h-100">
                            <img src="{{ $photo->url }}" class="card-img-top" alt="Gallery Photo" style="height: 200px; object-fit: cover;">

                            @if($photo->is_cover_photo)
                                <span class="badge bg-primary" style="position: absolute; top: 10px; left: 10px;">Cover Photo</span>
                            @endif

                            <div class="card-body text-center d-flex justify-content-center align-items-center" style="gap: 10px;">
                                @if(!$photo->is_cover_photo)
                                    <form action="{{ route('admin.photos.setCover', $photo) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-secondary btn-sm">Make Cover</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center">No photos have been uploaded to this gallery yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
