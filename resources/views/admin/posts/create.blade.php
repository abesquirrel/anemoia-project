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
                <div class="row">
                    {{-- LEFT COLUMN: Content --}}
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Post Content</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label font-weight-bold">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Enter a catchy title..." required>
                                </div>

                                <div class="mb-3">
                                    <label for="body" class="form-label font-weight-bold">Content Body</label>
                                    <textarea class="form-control" id="body" name="body" rows="15" placeholder="Write your story here..." required>{{ old('body') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Link to Gallery --}}
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Gallery Association</h6>
                            </div>
                            <div class="card-body">
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
                                    <small class="text-muted">Linking a gallery allows you to select a cover photo from that gallery below.</small>
                                </div>

                                {{-- VISUAL PHOTO SELECTOR --}}
                                <div class="p-3 border rounded bg-light mt-3">
                                    <label class="form-label font-weight-bold small text-uppercase text-muted mb-3">Cover Photo Selection</label>
                                    <div class="d-flex align-items-center flex-wrap">
                                         <input type="hidden" id="cover_photo_id" name="cover_photo_id" value="{{ old('cover_photo_id') }}">

                                        {{-- Preview Box --}}
                                        <div id="main-preview-container" class="border rounded bg-white d-flex align-items-center justify-content-center shadow-sm position-relative mr-3 mb-2"
                                             style="width: 120px; height: 120px; overflow: hidden; flex-shrink: 0;">
                                            <img id="main-preview-img" src="" class="d-none w-100 h-100" style="object-fit: cover;">
                                            <span id="main-preview-placeholder" class="text-muted small text-center px-2">No Photo<br>Selected</span>
                                            <button type="button" id="clear-selection-btn" class="btn btn-sm btn-danger position-absolute top-0 right-0 m-1 p-0 d-none"
                                                    style="width: 20px; height: 20px; line-height: 1;" title="Remove Selection">&times;</button>
                                        </div>

                                        {{-- Trigger Button --}}
                                        <div class="flex-grow-1">
                                            <button type="button" class="btn btn-outline-primary btn-block mb-2" id="open-photo-modal" disabled>
                                                <i class="fas fa-images mr-2"></i> Browse Gallery Photos
                                            </button>
                                            <div class="small text-muted font-italic" id="gallery-hint">
                                                Select a gallery above to enable.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: Meta Data --}}
                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Publishing & Media</h6>
                            </div>
                            <div class="card-body">
                                {{-- Publish Date --}}
                                <div class="mb-4">
                                    <label for="published_at" class="form-label font-weight-bold">Publish Date</label>
                                    <div class="input-group">
                                        <input type="datetime-local" class="form-control" id="published_at" name="published_at"
                                               value="{{ old('published_at') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('published_at').value = ''">
                                                Clear
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a href="#" class="small font-weight-bold text-primary" onclick="setNow(event)">Publish Immediately</a>
                                    </div>
                                    <small class="form-text text-muted mt-1">Leave blank to save as Draft.</small>
                                </div>

                                <hr>

                                {{-- Featured Image Upload --}}
                                <div class="mb-4">
                                    <label class="form-label font-weight-bold">Featured Image (Upload)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="featured_image" name="featured_image"
                                               onchange="document.getElementById('file-label').textContent = this.files[0] ? this.files[0].name : 'Choose file'">
                                        <label class="custom-file-label" id="file-label" for="featured_image">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted mt-2">
                                        <i class="fas fa-info-circle mr-1"></i> Overrides any selected gallery photo.
                                    </small>
                                </div>

                                <hr>
                                
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    <i class="fas fa-paper-plane mr-2"></i> Create Post
                                </button>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-light btn-block text-secondary border">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="photoSelectorModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select a Cover Photo</h5>
                    {{-- FIXED: data-dismiss for Bootstrap 4 --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row" id="modal-photo-grid">
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
                    div.className = 'col-6 col-md-4 col-lg-3 mb-3';
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
