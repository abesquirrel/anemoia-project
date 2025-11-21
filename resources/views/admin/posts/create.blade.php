@extends('layouts.admin')

@section('content')
    <div class="mb-3">
        <label for="gallery_id" class="form-label font-weight-bold">Link a Gallery (Optional)</label>
        <select class="form-control" id="gallery_id" name="gallery_id">
            <option value="">-- No Gallery --</option>
            @foreach($galleries as $gallery)
                <option value="{{ $gallery->id }}" {{ old('gallery_id') == $gallery->id ? 'selected' : '' }}>
                    {{ $gallery->title }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">If selected, a link to this gallery will appear at the bottom of the post.</small>
    </div>

    {{-- VISUAL PHOTO SELECTOR --}}
    <div class="mb-4">
        <label class="form-label font-weight-bold">Cover Photo (From Selected Album)</label>

        {{-- 1. The Hidden Field (Stores the actual ID for the database) --}}
        <input type="hidden" id="cover_photo_id" name="cover_photo_id" value="{{ isset($post) ? $post->cover_photo_id : '' }}">

        <div class="d-flex align-items-center gap-4">

            {{-- 2. The Preview Box --}}
            <div id="main-preview-container" class="border rounded bg-light d-flex align-items-center justify-content-center shadow-sm position-relative"
                 style="width: 150px; height: 100px; overflow: hidden; background-color: #f8f9fa;">

                {{-- Image (Hidden if empty) --}}
                <img id="main-preview-img" src="" class="d-none w-100 h-100" style="object-fit: cover;">

                {{-- Placeholder Text (Visible if empty) --}}
                <span id="main-preview-placeholder" class="text-muted small text-center px-2">
                No Photo Selected
            </span>

                {{-- Clear Button (X) --}}
                <button type="button" id="clear-selection-btn" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-0 d-none"
                        style="width: 20px; height: 20px; line-height: 1;" title="Remove Selection">
                    &times;
                </button>
            </div>

            {{-- 3. The Trigger Button --}}
            <div>
                <button type="button" class="btn btn-outline-primary" id="open-photo-modal" disabled>
                    <i class="fas fa-images me-2"></i> Browse Album Photos
                </button>
                <div class="form-text text-muted mt-1" id="gallery-hint">
                    Select a gallery above to enable this.
                </div>
            </div>
        </div>
    </div>

    {{-- 4. THE MODAL (Popup Grid) --}}
    <div class="modal fade" id="photoSelectorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select a Cover Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    {{-- Grid Container --}}
                    <div class="row g-3" id="modal-photo-grid">
                        {{-- Photos will be injected here via JS --}}
                        <div class="col-12 text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted">Loading photos...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. JAVASCRIPT LOGIC --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const gallerySelect = document.getElementById('gallery_id');
            const hiddenInput = document.getElementById('cover_photo_id');
            const openModalBtn = document.getElementById('open-photo-modal');
            const galleryHint = document.getElementById('gallery-hint');

            // Modal Elements
            const modalEl = document.getElementById('photoSelectorModal');
            const modalGrid = document.getElementById('modal-photo-grid');
            const bsModal = new bootstrap.Modal(modalEl);

            // Preview Elements
            const previewImg = document.getElementById('main-preview-img');
            const previewPlaceholder = document.getElementById('main-preview-placeholder');
            const clearBtn = document.getElementById('clear-selection-btn');

            // Cache
            let currentGalleryPhotos = [];

            // --- FUNCTIONS ---

            // 1. Update Main UI (Preview Box)
            function updateMainPreview(url) {
                if (url) {
                    previewImg.src = url;
                    previewImg.classList.remove('d-none');
                    clearBtn.classList.remove('d-none');
                    previewPlaceholder.classList.add('d-none');
                } else {
                    previewImg.src = '';
                    previewImg.classList.add('d-none');
                    clearBtn.classList.add('d-none');
                    previewPlaceholder.classList.remove('d-none');
                }
            }

            // 2. Fetch Photos
            function fetchPhotos(galleryId) {
                // Disable button while loading
                openModalBtn.disabled = true;
                galleryHint.textContent = "Loading photos...";

                fetch(`/admin/galleries/${galleryId}/get-photos`)
                    .then(response => response.json())
                    .then(data => {
                        currentGalleryPhotos = data;
                        openModalBtn.disabled = false;
                        galleryHint.textContent = `${data.length} photos available.`;

                        // If we have a saved ID (editing), find its URL and show preview
                        const savedId = hiddenInput.value;
                        if (savedId) {
                            const photo = data.find(p => p.id == savedId);
                            if (photo) updateMainPreview(photo.url);
                        }
                    });
            }

            // 3. Render Grid (When Modal Opens)
            function renderGrid() {
                modalGrid.innerHTML = '';

                if (currentGalleryPhotos.length === 0) {
                    modalGrid.innerHTML = '<div class="col-12 text-center text-muted py-4">No photos in this gallery.</div>';
                    return;
                }

                currentGalleryPhotos.forEach(photo => {
                    const isSelected = (photo.id == hiddenInput.value);

                    // Create Card HTML
                    const div = document.createElement('div');
                    div.className = 'col-6 col-md-4 col-lg-3';
                    div.innerHTML = `
                    <div class="card h-100 photo-select-card ${isSelected ? 'border-primary ring-2' : 'border-0'}"
                         style="cursor: pointer; transition: transform 0.2s;"
                         onclick="selectPhoto(${photo.id}, '${photo.url}')">
                        <div class="position-relative" style="aspect-ratio: 1/1;">
                            <img src="${photo.url}" class="w-100 h-100 rounded" style="object-fit: cover;">
                            ${isSelected ? '<div class="position-absolute top-0 end-0 m-1 badge bg-primary"><i class="fas fa-check"></i></div>' : ''}
                        </div>
                    </div>
                `;
                    modalGrid.appendChild(div);
                });
            }

            // 4. Handle Selection (Global function for onclick)
            window.selectPhoto = function(id, url) {
                hiddenInput.value = id; // Save ID
                updateMainPreview(url); // Update Preview
                bsModal.hide(); // Close Modal
            };

            // --- EVENTS ---

            // When Gallery Dropdown Changes
            gallerySelect.addEventListener('change', function() {
                const galleryId = this.value;

                // Clear previous selection when gallery changes
                hiddenInput.value = '';
                updateMainPreview(null);

                if (galleryId) {
                    fetchPhotos(galleryId);
                } else {
                    openModalBtn.disabled = true;
                    galleryHint.textContent = "Select a gallery above to enable this.";
                }
            });

            // When "Clear" (X) is clicked
            clearBtn.addEventListener('click', function() {
                hiddenInput.value = '';
                updateMainPreview(null);
            });

            // When Modal Trigger is clicked
            openModalBtn.addEventListener('click', function() {
                renderGrid(); // Render fresh grid
                bsModal.show();
            });

            // Initialize on Page Load (For Edit Page)
            if (gallerySelect.value) {
                fetchPhotos(gallerySelect.value);
            }
        });
    </script>

    <style>
        /* Hover effect for grid items */
        .photo-select-card:hover {
            transform: scale(1.05);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
            z-index: 10;
        }
        .ring-2 {
            box-shadow: 0 0 0 3px rgba(100, 161, 157, 0.5); /* Primary color glow */
        }
    </style>

    <h1 class="h3 mb-4 text-gray-800">Create New Post</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label font-weight-bold">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label font-weight-bold">Body</label>
                    <textarea class="form-control" id="body" name="body" rows="10" required>{{ old('body') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="featured_image" class="form-label font-weight-bold">Featured Image (Optional)</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="published_at" class="form-label font-weight-bold">Publish Date (Optional)</label>
                        <input type="datetime-local" class="form-control" id="published_at" name="published_at" value="{{ old('published_at') }}">
                        <small class="form-text text-muted">Leave blank to publish immediately.</small>
                    </div>
                </div>

                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Post</button>
            </form>
        </div>
    </div>
@endsection
