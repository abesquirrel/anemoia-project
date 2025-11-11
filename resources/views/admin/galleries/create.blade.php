<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Gallery
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- This block will show validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- This form submits to the 'store' method in our controller --}}
                    <form action="{{ route('admin.galleries.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="camera" class="form-label">Camera (Optional)</label>
                                <input type="text" class="form-control" id="camera" name="camera" value="{{ old('camera') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="film" class="form-label">Film (Optional)</label>
                                <input type="text" class="form-control" id="film" name="film" value="{{ old('film') }}">
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" value="1" checked>
                            <label class="form-check-label" for="is_visible">
                                Visible on public site
                            </label>
                        </div>

                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Gallery</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
