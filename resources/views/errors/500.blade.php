@extends('layouts.site')

@section('title', '500 - Server Error')

@section('content')
<section class="error-section text-center text-white" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 100%), url('{{ asset('assets/img/bg-masthead.webp') }}') no-repeat center center; background-size: cover;">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8">
                <i class="fas fa-exclamation-triangle fa-5x mb-4" style="color: #e4c662;"></i>
                <h1 class="display-3 font-weight-bold mb-4" style="color: #64a19d;">500</h1>
                <h2 class="text-white-75 mb-4">Internal Server Error</h2>
                <p class="text-white-50 mb-5 lead">
                    Something went wrong on our end. We're working to fix it.
                </p>
                <div class="mb-5 p-4 text-center" style="background: rgba(0, 0, 0, 0.3); border-radius: 8px; border-left: 4px solid #e4c662;">
                    <p class="text-white-50 font-monospace mb-1">Code: 500</p>
                    <p class="text-white-50 font-monospace mb-0">Status: Internal Server Error</p>
                </div>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-xl">
                        <i class="fas fa-home mr-2"></i> Back to Home
                    </a>
                    <a href="javascript:window.location.reload()" class="btn btn-light btn-xl">
                        <i class="fas fa-redo mr-2"></i> Retry
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
