@extends('layouts.admin')

@section('content')
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
