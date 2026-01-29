@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Gallery: <span class="fw-light">{{ $gallery->title }}</span></h1>

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

            <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- LEFT COLUMN: Main Content --}}
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Gallery Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label font-weight-bold">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label font-weight-bold">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $gallery->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Technical Specs</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="camera" class="form-label">Camera</label>
                                        <input type="text" class="form-control" id="camera" name="camera" value="{{ old('camera', $gallery->camera) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="lens" class="form-label">Lens</label>
                                        <input type="text" class="form-control" id="lens" name="lens" value="{{ old('lens', $gallery->lens) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="film" class="form-label">Film Stock</label>
                                        <input type="text" class="form-control" id="film" name="film" value="{{ old('film', $gallery->film) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: Meta Data & Actions --}}
                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Publishing</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" value="1"
                                        {{ old('is_visible', $gallery->is_visible) ? 'checked' : '' }}>
                                    <label class="form-check-label font-weight-bold" for="is_visible">
                                        Visible on Public Site
                                    </label>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="show_exif" name="show_exif" value="1"
                                        {{ old('show_exif', $gallery->show_exif) ? 'checked' : '' }}
                                        onchange="document.getElementById('exif-settings').style.display = this.checked ? 'block' : 'none'">
                                    <label class="form-check-label font-weight-bold" for="show_exif">
                                        Show EXIF Data in Lightbox
                                    </label>
                                    <small class="form-text text-muted d-block mt-1">
                                        <i class="fas fa-camera-retro text-primary"></i> Display technical details when viewing photos
                                    </small>
                                </div>

                                <div id="exif-settings" class="ml-4 mb-4 pl-3 border-left" style="display: {{ old('show_exif', $gallery->show_exif) ? 'block' : 'none' }}; border-color: #e3e6f0;">
                                    
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="show_exif_on_first_only" name="show_exif_on_first_only" value="1"
                                            {{ old('show_exif_on_first_only', $gallery->show_exif_on_first_only) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_exif_on_first_only">
                                            Only show on first photo
                                        </label>
                                        <small class="form-text text-muted">Useful for minimal looks.</small>
                                    </div>

                                    <div class="mb-2">
                                        <label class="font-weight-bold small text-uppercase text-gray-600">Fields to Display</label>
                                        <div class="d-flex flex-column">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="exif_fields[]" value="camera" id="field_camera"
                                                    {{ in_array('camera', old('exif_fields', $gallery->exif_fields ?? ['camera', 'lens', 'film'])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="field_camera">Camera</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="exif_fields[]" value="lens" id="field_lens"
                                                    {{ in_array('lens', old('exif_fields', $gallery->exif_fields ?? ['camera', 'lens', 'film'])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="field_lens">Lens</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="exif_fields[]" value="film" id="field_film"
                                                    {{ in_array('film', old('exif_fields', $gallery->exif_fields ?? ['camera', 'lens', 'film'])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="field_film">Film</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info small">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Last updated: {{ $gallery->updated_at->diffForHumans() }}
                                </div>

                                <hr>
                                
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    <i class="fas fa-save mr-2"></i> Update Gallery
                                </button>
                                <a href="{{ route('admin.galleries.index') }}" class="btn btn-light btn-block text-secondary border">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
