@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Create New Gallery</h1>

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

            <form action="{{ route('admin.galleries.store') }}" method="POST">
                @csrf
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
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Summer Roadtrip 2024" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label font-weight-bold">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="A brief story about this collection...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Technical Specs (Optional)</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="camera" class="form-label">Camera</label>
                                        <input type="text" class="form-control" id="camera" name="camera" value="{{ old('camera') }}" placeholder="e.g. Canon AE-1">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="lens" class="form-label">Lens</label>
                                        <input type="text" class="form-control" id="lens" name="lens" value="{{ old('lens') }}" placeholder="e.g. 50mm f/1.8">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="film" class="form-label">Film Stock</label>
                                        <input type="text" class="form-control" id="film" name="film" value="{{ old('film') }}" placeholder="e.g. Kodak Portra 400">
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
                                    <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" value="1" checked>
                                    <label class="form-check-label font-weight-bold" for="is_visible">
                                        Visible on Public Site
                                    </label>
                                    <small class="form-text text-muted">Uncheck to keep as a draft.</small>
                                </div>

                                <hr>
                                
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    <i class="fas fa-save mr-2"></i> Save Gallery
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
