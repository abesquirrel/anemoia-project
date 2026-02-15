@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Add Social Platform</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.social-platforms.index') }}">Social Settings</a></li>
            <li class="breadcrumb-item active">Add New</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.social-platforms.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                            value="{{ old('slug') }}" required>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="base_share_url" class="form-label">Share URL Pattern</label>
                        <input type="url" class="form-control @error('base_share_url') is-invalid @enderror"
                            id="base_share_url" name="base_share_url" value="{{ old('base_share_url') }}" required>
                        <div class="form-text">Use the full URL. The content URL will be appended to this.</div>
                        @error('base_share_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icon_class" class="form-label">Icon Class (FontAwesome)</label>
                        <input type="text" class="form-control @error('icon_class') is-invalid @enderror" id="icon_class"
                            name="icon_class" value="{{ old('icon_class') }}" required>
                        <div class="form-text">Example: fab fa-facebook-f</div>
                        @error('icon_class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color (Hex)</label>
                        <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                            id="color" name="color" value="{{ old('color', '#000000') }}">
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
                            name="sort_order" value="{{ old('sort_order', 0) }}">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save Platform</button>
                </form>
            </div>
        </div>
    </div>
@endsection