@extends('layouts.site')

@section('title', '403 - Access Denied')

@section('content')
<section class="error-section text-center text-white" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 100%), url('{{ asset('assets/img/bg-masthead.webp') }}') no-repeat center center; background-size: cover;">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8">
                <i class="fas fa-lock fa-5x mb-4" style="color: #a16468;"></i>
                <h1 class="display-3 font-weight-bold mb-4" style="color: #64a19d;">403</h1>
                <h2 class="text-white-75 mb-4">Access Denied</h2>
                <p class="text-white-50 mb-2 lead">
                    You don't have permission to access this resource.
                </p>
                <p class="text-white-50 mb-5 font-monospace">
                    > USER: {{ auth()->check() ? auth()->user()->name : 'GUEST' }}
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-xl">
                        <i class="fas fa-home mr-2"></i> Back to Home
                    </a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-xl">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
