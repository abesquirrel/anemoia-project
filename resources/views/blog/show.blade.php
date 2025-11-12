@extends('layouts.site')

@section('content')
    @php
        // Use post's image if it exists, otherwise use default
        $bgImage = $post->featured_image ? Storage::url($post->featured_image) : asset('assets/img/bg-masthead.jpg');
    @endphp
    <header class="masthead" style="background-image: url('{{ $bgImage }}')">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">{{ $post->title }}</h1>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">
                        By {{ $post->user->name }} on {{ $post->published_at->format('F d, Y') }}
                    </h2>
                </div>
            </div>
        </div>
    </header>

    <section class="about-section" id="post-content">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-10">
                    {{-- We use bg-light and p-5 for a readable white background --}}
                    <div class="bg-light p-4 p-md-5 rounded">
                        {{--
                            We use {!! ... !!} to render HTML,
                            nl2br() to turn line breaks into <br> tags,
                            and e() to escape HTML to prevent XSS attacks.
                            This makes writing in the textarea safe and user-friendly.
                        --}}
                        <div class="post-body text-black" style="font-size: 1.1rem; line-height: 1.7;">
                            {!! nl2br(e($post->body)) !!}
                        </div>

                        <hr class="my-4">
                        <a href="{{ route('blog.index') }}" class="btn btn-primary">&larr; Back to Blog</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
