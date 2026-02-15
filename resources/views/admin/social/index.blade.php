@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Social Settings</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Social Settings</li>
        </ol>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Global Toggle Section --}}
        <div class="card mb-4 border-left-primary">
            <div class="card-body">
                <form action="{{ route('admin.social-platforms.toggle-global') }}" method="POST" class="d-flex align-items-center justify-content-between">
                    @csrf
                    @method('PATCH')
                    <div>
                        <h5 class="mb-0 font-weight-bold text-primary">Master Switch</h5>
                        <p class="mb-0 text-muted small">Enable or disable social sharing buttons across the entire website.</p>
                    </div>
                    <div class="custom-control custom-switch custom-switch-lg">
                        @php $globalEnabled = \App\Models\Setting::get('social_share_enabled', '1') === '1'; @endphp
                        <input type="hidden" name="social_share_enabled" value="0">
                        <input type="checkbox" name="social_share_enabled" value="1" 
                            class="custom-control-input" id="globalSocialSwitch" 
                            {{ $globalEnabled ? 'checked' : '' }}
                            onchange="this.form.submit()">
                        <label class="custom-control-label" for="globalSocialSwitch">
                            <span class="badge {{ $globalEnabled ? 'badge-success' : 'badge-danger' }}">
                                {{ $globalEnabled ? 'System Enabled' : 'System Disabled' }}
                            </span>
                        </label>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <div>
                    <i class="fas fa-share-alt me-1 text-primary"></i>
                    <span class="font-weight-bold">Social Platforms</span>
                    <small class="text-muted ml-2">(Drag rows to reorder)</small>
                </div>
                <a href="{{ route('admin.social-platforms.create') }}" class="btn btn-primary btn-sm rounded-pill shadow-sm">
                    <i class="fas fa-plus fa-sm"></i> Add New Platform
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="platformsTable">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th style="width: 50px;"></th>
                                <th style="width: 80px;">Icon</th>
                                <th>Name</th>
                                <th style="width: 150px;">Status</th>
                                <th class="d-none d-md-table-cell">Share Pattern</th>
                                <th style="width: 120px;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortablePlatforms">
                            @foreach($platforms as $platform)
                                <tr data-id="{{ $platform->id }}" class="align-middle">
                                    <td class="text-center drag-handle" style="cursor: move;">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </td>
                                    <td class="text-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                             style="width: 40px; height: 40px; background-color: {{ $platform->color }}; color: white;">
                                            <i class="{{ $platform->icon_class }}"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $platform->name }}</span>
                                        <br><small class="text-muted">{{ $platform->slug }}</small>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.social-platforms.update', $platform) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="is_active" value="{{ $platform->is_active ? 0 : 1 }}">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="switch{{ $platform->id }}" 
                                                    {{ $platform->is_active ? 'checked' : '' }}
                                                    onclick="this.form.submit()">
                                                <label class="custom-control-label small" for="switch{{ $platform->id }}">
                                                    {{ $platform->is_active ? 'Active' : 'Inactive' }}
                                                </label>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <code class="small text-muted">{{ Str::limit($platform->base_share_url, 30) }}</code>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.social-platforms.edit', $platform) }}"
                                                class="btn btn-sm btn-outline-warning border-0" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.social-platforms.destroy', $platform) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .custom-switch-lg .custom-control-label::before {
            height: 1.5rem;
            width: 2.75rem;
            border-radius: 1rem;
        }
        .custom-switch-lg .custom-control-label::after {
            width: calc(1.5rem - 4px);
            height: calc(1.5rem - 4px);
            border-radius: 1rem;
        }
        .custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(1.25rem);
        }
        tr.sortable-ghost {
            opacity: 0.4;
            background-color: #f8f9fc !important;
        }
        .drag-handle:hover {
            color: #4e73df !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('sortablePlatforms');
            if (el) {
                Sortable.create(el, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function() {
                        const order = Array.from(el.querySelectorAll('tr')).map(tr => tr.dataset.id);
                        
                        fetch('{{ route('admin.social-platforms.reorder') }}', {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order: order })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Optional: Flash sound or small toast
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            }
        });
    </script>
    @endpush
@endsection