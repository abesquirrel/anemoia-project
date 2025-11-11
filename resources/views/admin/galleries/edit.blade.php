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

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $gallery->description) }}</textarea>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <label for="camera" class="form-label">Camera (Optional)</label>
                        <input type="text" class="form-control" id="camera" name="camera" value="{{ old('camera', $gallery->camera) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="lens" class="form-label">Lens (Optional)</label>
                        <input type="text" class="form-control" id="lens" name="lens" value="{{ old('lens', $gallery->lens) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="film" class="form-label">Film (Optional)</label>
                        <input type="text" class="form-control" id="film" name="film" value="{{ old('film', $gallery->film) }}">
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" value="1"
                        {{ old('is_visible', $gallery->is_visible) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_visible">
                        Visible on public site
                    </label>
                </div>

                <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Gallery</button>
            </form>
        </div>
    </div>
@endsection
