@extends('layouts.site')

@section('title', '404 - Page Not Found')

@section('content')
<section class="error-section text-center text-white" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 100%), url('{{ asset('assets/img/bg-masthead.webp') }}') no-repeat center center; background-size: cover;">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-1 font-weight-bold mb-4" style="font-size: 10rem; color: #64a19d;">404</h1>
                <h2 class="text-white-75 mb-4">Page Not Found</h2>
                <p class="text-white-50 mb-5 lead">
                    The page you're looking for doesn't exist or has been moved.
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
