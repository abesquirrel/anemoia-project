<x-app-layout>
    {{-- This is the header slot, defined in Breeze's app.blade.php --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Galleries
            </h2>

            {{-- Link to the "create" route we defined --}}
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm">
                + New Gallery
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- This will show the green "success" message on redirect --}}
                    @if (session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif

                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th style="width: 10%;">Visible</th>
                            <th style="width: 10%;">Photo Count</th>
                            <th style="width: 15%;">Created</th>
                            <th style="width: 25%;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- We loop through the $galleries from the controller --}}
                        @forelse ($galleries as $gallery)
                            <tr>
                                <td>{{ $gallery->title }}</td>
                                <td>
                                    @if($gallery->is_visible)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>{{ $gallery->photos_count }}</td>
                                <td>{{ $gallery->created_at->format('Y-m-d') }}</td>
                                <td>
                                    {{-- Link to our Photo Manager --}}
                                    <a href="{{ route('admin.photos.index', $gallery) }}" class="btn btn-info btn-sm">Photos</a>

                                    {{-- Link to the "edit" route --}}
                                    <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-warning btn-sm">Edit</a>

                                    {{-- This is a mini-form for the "delete" button --}}
                                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this gallery? This is permanent.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No galleries found. Create one!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
