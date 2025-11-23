@extends('layouts.admin')

@section('content')

    <style>
        .photo-select-card:hover {
            transform: scale(1.05);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
            z-index: 10;
        }
        .ring-2 {
            box-shadow: 0 0 0 3px rgba(100, 161, 157, 0.5); /* Primary color glow */
        }
        /* Custom File Input Style */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
    </style>

    <h1 class="h3 mb-4 text-gray-800">Edit Post</h1>

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

            {{-- FORM STARTS HERE --}}
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label font-weight-bold">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                </div>

                {{-- 1. GALLERY SELECTOR (Required for logic) --}}
                <div class="mb-3">
                    <label for="gallery_id" class="form-label font-weight-bold">Link a Gallery (Optional)</label>
                    <select class="form-control" id="gallery_id" name="gallery_id">
                        <option value="">-- No Gallery --</option>
                        @foreach($galleries as $gallery)
                            <option value="{{ $gallery->id }}" {{ old('gallery_id', $post->gallery_id) == $gallery->id ? 'selected' : '' }}>
                                {{ $gallery->title }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Selecting a gallery enables the photo selector below.</small>
                </div>

                {{-- 2. VISUAL PHOTO SELECTOR --}}
                <div class="mb-4 p-3 border rounded bg-light">
                    <label class="form-label font-weight-bold">Cover Photo (From Selected Album)</label>

                    {{-- Hidden Field to store the selection --}}
                    <input type="hidden" id="cover_photo_id" name="cover_photo_id" value="{{ old('cover_photo_id', $post->cover_photo_id) }}">

                    <div class="d-flex align-items-center">
                        {{-- Preview Box --}}
                        <div id="main-preview-container" class="border rounded bg-white d-flex align-items-center justify-content-center shadow-sm position-relative"
                             style="width: 150px; height: 100px; overflow: hidden; flex-shrink: 0;">
                            <img id="main-preview-img" src="" class="d-none w-100 h-100" style="object-fit: cover;">
                            <span id="main-preview-placeholder" class="text-muted small text-center px-2">No Photo Selected</span>
                            <button type="button" id="clear-selection-btn" class="btn btn-sm btn-danger position-absolute top-0 right-0 m-1 p-0 d-none"
                                    style="width: 20px; height: 20px; line-height: 1;" title="Remove Selection">&times;</button>
                        </div>

                        {{-- Trigger Button --}}
                        <div class="ml-4"> {{-- Changed ms-4 to ml-4 for Bootstrap 4 --}}
                            <button type="button" class="btn btn-outline-primary" id="open-photo-modal" disabled>
                                <i class="fas fa-images me-2"></i> Browse Album Photos
                            </button>
                            <div class="form-text text-muted mt-1" id="gallery-hint">
                                Select a gallery above to enable this.
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END VISUAL SELECTOR --}}

                <div class="mb-3">
                    <label for="body" class="form-label font-weight-bold">Body</label>
                    <textarea class="form-control" id="body" name="body" rows="10" required>{{ old('body', $post->body) }}</textarea>
                </div>

                <div class="row">
                    {{-- Featured Image (Custom Upload) --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Featured Image (Custom Upload)</label>

                        {{-- Styled File Input --}}
                        <div class="d-flex align-items-center">
                            <label class="btn btn-outline-secondary mb-0" for="featured_image">
                                <i class="fas fa-upload me-2"></i> Choose File
                            </label>
                            <input type="file" class="d-none" id="featured_image" name="featured_image"
                                   onchange="document.getElementById('file-name-display').textContent = this.files[0] ? this.files[0].name : 'No file chosen'">
                            <span id="file-name-display" class="ml-3 text-muted font-italic">No file chosen</span> {{-- Changed ms-3 to ml-3 --}}
                        </div>

                        @if($post->featured_image)
                            <div class="mt-3 p-2 border rounded bg-white">
                                <div class="d-flex align-items-center">
                                    <img src="{{ Storage::url($post->featured_image) }}" class="mr-3 rounded" style="width: 60px; height: 60px; object-fit: cover;"> {{-- Changed me-3 to mr-3 --}}
                                    <div>
                                        <small class="text-muted d-block mb-1">Current Image</small>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remove_featured_image" name="remove_featured_image" value="1">
                                            <label class="form-check-label text-danger small" for="remove_featured_image">
                                                Remove this image
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <small class="form-text text-muted mt-2 d-block">Overrides the selected Album Photo.</small>
                    </div>

                    {{-- Publish Date --}}
                    <div class="col-md-6 mb-3">
                        <label for="published_at" class="form-label font-weight-bold">Publish Date</label>
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" id="published_at" name="published_at"
                                   value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('published_at').value = ''">
                                    Clear
                                </button>
                            </div>
                        </div>
                        <div class="form-text text-muted mt-1">
                            <a href="#" class="text-decoration-none" onclick="setNow(event)">Click here to set to NOW</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Post</button>
            </form>
            {{-- FORM ENDS HERE --}}
        </div>
    </div>

    {{-- MODAL (Outside form) --}}
    <div class="modal fade" id="photoSelectorModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select a Cover Photo</h5>
                    {{-- FIXED: data-dismiss instead of data-bs-dismiss for Bootstrap 4 --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row" id="modal-photo-grid"> {{-- Removed g-3 (Bootstrap 5 only) --}}
                        <div class="col-12 text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted">Loading photos...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function setNow(e) {
            e.preventDefault();
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('published_at').value = now.toISOString().slice(0, 16);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const gallerySelect = document.getElementById('gallery_id');
            const hiddenInput = document.getElementById('cover_photo_id');
            const openModalBtn = document.getElementById('open-photo-modal');
            const galleryHint = document.getElementById('gallery-hint');
            const modalEl = document.getElementById('photoSelectorModal');
            const modalGrid = document.getElementById('modal-photo-grid');

            // Use jQuery for Modal in Bootstrap 4
            const showModal = () => $('#photoSelectorModal').modal('show');
            const hideModal = () => $('#photoSelectorModal').modal('hide');

            const previewImg = document.getElementById('main-preview-img');
            const previewPlaceholder = document.getElementById('main-preview-placeholder');
            const clearBtn = document.getElementById('clear-selection-btn');
            let currentGalleryPhotos = [];

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

            function fetchPhotos(galleryId) {
                openModalBtn.disabled = true;
                galleryHint.textContent = "Loading photos...";
                fetch(`/admin/galleries/${galleryId}/get-photos`)
                    .then(response => response.json())
                    .then(data => {
                        currentGalleryPhotos = data;
                        openModalBtn.disabled = false;
                        galleryHint.textContent = `${data.length} photos available.`;

                        const savedId = hiddenInput.value;
                        if (savedId) {
                            const photo = data.find(p => p.id == savedId);
                            if (photo) updateMainPreview(photo.url);
                        }
                    });
            }

            function renderGrid() {
                modalGrid.innerHTML = '';
                if (currentGalleryPhotos.length === 0) {
                    modalGrid.innerHTML = '<div class="col-12 text-center text-muted py-4">No photos in this gallery.</div>';
                    return;
                }
                currentGalleryPhotos.forEach(photo => {
                    const isSelected = (photo.id == hiddenInput.value);
                    const div = document.createElement('div');
                    div.className = 'col-6 col-md-4 col-lg-3 mb-3'; // Added mb-3 for vertical spacing
                    div.innerHTML = `
                    <div class="card h-100 photo-select-card ${isSelected ? 'border-primary ring-2' : 'border-0'}"
                         style="cursor: pointer; transition: transform 0.2s;"
                         onclick="selectPhoto(${photo.id}, '${photo.url}')">
                        <div class="position-relative" style="aspect-ratio: 1/1;">
                            <img src="${photo.url}" class="w-100 h-100 rounded" style="object-fit: cover;">
                            ${isSelected ? '<div class="position-absolute top-0 right-0 m-1 badge badge-primary"><i class="fas fa-check"></i></div>' : ''}
                        </div>
                    </div>`;
                    modalGrid.appendChild(div);
                });
            }

            window.selectPhoto = function(id, url) {
                hiddenInput.value = id;
                updateMainPreview(url);
                hideModal();
            };

            gallerySelect.addEventListener('change', function() {
                const galleryId = this.value;
                hiddenInput.value = '';
                updateMainPreview(null);
                if (galleryId) {
                    fetchPhotos(galleryId);
                } else {
                    openModalBtn.disabled = true;
                    galleryHint.textContent = "Select a gallery above to enable this.";
                }
            });

            clearBtn.addEventListener('click', function() {
                hiddenInput.value = '';
                updateMainPreview(null);
            });

            openModalBtn.addEventListener('click', function() {
                renderGrid();
                showModal();
            });

            if (gallerySelect.value) {
                fetchPhotos(gallerySelect.value);
            }
        });
    </script>
@endsection
