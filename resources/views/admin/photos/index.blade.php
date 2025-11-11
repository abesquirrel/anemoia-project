<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Photos for: <span class="fw-light">{{ $gallery->title }}</span>
            </h2>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary btn-sm">
                &larr; Back to Galleries
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Show success/error messages --}}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900">
                    <h3 class="h5 mb-3 fw-bold">Upload New Photos</h3>

                    {{-- This form MUST have enctype="multipart/form-data" to handle file uploads --}}
                    <form action="{{ route('admin.photos.store', $gallery) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="photos" class="form-label">Select Photos (multiple allowed)</label>

                            {{-- The name="photos[]" (with brackets) is critical for multiple uploads --}}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="h5 mb-3 fw-bold">Existing Photos ({{ $gallery->photos->count() }})</h3>
                    <div class="row gx-3 gy-3">

                        {{-- We loop through all photos in this gallery --}}
                        @forelse ($gallery->photos as $photo)
                            <div class="col-md-3">
                                <div class="card h-100">
                                    {{-- Use the ->url accessor from the Photo model --}}
                                    <img src="{{ $photo->url }}"
                                         class="card-img-top"
                                         alt="Gallery Photo"
                                         style="height: 200px; object-fit: cover;">

                                    <div class="card-body text-center">
                                        {{-- Delete form for this specific photo --}}
                                        <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?');">
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

        </div>
    </div>
</x-app-layout>
