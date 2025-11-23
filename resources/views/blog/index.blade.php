@extends('layouts.site')

@section('content')

    <style>
        /* --- HEADER --- */
        .masthead {
            position: relative;
            width: 100%;
            height: auto;
            min-height: 35rem;
            padding: 15rem 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 75%, #000000 100%), url('{{ asset('assets/img/bg-masthead.webp') }}');
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: scroll;
            background-size: cover;
        }

        /* --- HERO CARD (The "Floating" Look) --- */
        .hero-card {
            background: #0a0a0a; /* Very dark grey background */
            border: 1px solid rgba(255, 255, 255, 0.15); /* The Border you requested */
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .hero-card:hover {
            transform: translateY(-10px); /* Float up */
            border-color: #64a19d; /* Accent color on border */
            box-shadow: 0 15px 30px rgba(0,0,0,0.5); /* Glow effect */
        }

        /* --- GRID CARDS --- */
        .blog-card {
            transition: transform 0.3s ease;
            background: transparent;
            border: none;
            height: 100%;
            display: block;
        }
        .blog-card:hover {
            transform: translateY(-10px);
        }

        /* --- IMAGE STYLES --- */
        .blog-img-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 8px; /* Rounded images */
            width: 100%;
        }

        /* Hero Image - No border radius on left side to flush with card */
        .hero-img-wrapper {
            height: 100%;
            min-height: 400px;
        }

        /* Grid Images - Rounded */
        .grid-img-wrapper {
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            aspect-ratio: 3/2;
        }

        .blog-img-wrapper img {
            transition: transform 0.5s ease;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-card:hover .hero-img-wrapper img,
        .blog-card:hover .grid-img-wrapper img {
            transform: scale(1.05); /* Zoom on hover */
        }
    </style>

    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">The Unreliable Narrator</h1>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">What I know, what I thought, what I’m still figuring out.</h2>
                </div>
            </div>
        </div>
    </header>

    <section class="bg-black py-5" id="blog-list">
        <div class="container px-4 px-lg-5">

            {{-- HERO POST --}}
            @if($heroPost)
                @php
                    // IMAGE PRIORITY LOGIC
                    $heroImg = asset('assets/img/bg-masthead.webp');
                    if ($heroPost->featured_image) {
                        $heroImg = Storage::url($heroPost->featured_image);
                    } elseif ($heroPost->coverPhoto) {
                        $heroImg = $heroPost->coverPhoto->url;
                    } elseif ($heroPost->gallery) {
                        $heroImg = $heroPost->gallery->cover_photo_url;
                    }
                @endphp

                {{-- UPDATED: Removed 'border-bottom border-secondary' classes --}}
                <div class="row mb-5 pb-5 justify-content-center">

                    {{-- Constrained width (col-xl-10) to make card smaller/centered --}}
                    <div class="col-xl-10">

                        {{-- THE HERO CARD --}}
                        <div class="hero-card fade-in-up">
                            <div class="row g-0 align-items-stretch">

                                {{-- Image Side --}}
                                <div class="col-lg-7">
                                    <div class="blog-img-wrapper hero-img-wrapper">
                                        <a href="{{ route('blog.show', $heroPost->slug) }}">
                                            <img src="{{ $heroImg }}" alt="{{ $heroPost->title }}">
                                        </a>
                                    </div>
                                </div>

                                {{-- Text Side --}}
                                <div class="col-lg-5 d-flex align-items-center">
                                    <div class="p-4 p-lg-5 text-center text-lg-start">
                                        <div class="text-uppercase text-primary fw-bold mb-2 small" style="letter-spacing: 2px;">
                                            Latest &bull; {{ $heroPost->published_at->format('M d, Y') }}
                                        </div>
                                        <h3 class="mb-3">
                                            <a href="{{ route('blog.show', $heroPost->slug) }}" class="text-white text-decoration-none display-6 fw-bold">{{ $heroPost->title }}</a>
                                        </h3>
                                        <p class="text-white-50 mb-4">{{ Str::limit(strip_tags($heroPost->body), 160) }}</p>
                                        <a class="btn btn-outline-light rounded-pill px-4" href="{{ route('blog.show', $heroPost->slug) }}">Read Story</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- END HERO CARD --}}

                    </div>
                </div>
            @endif

            {{-- GRID POSTS --}}
            @if($gridPosts->count() > 0)
                <div class="row gx-5 gx-lg-5 justify-content-center mt-5">
                    @foreach ($gridPosts as $post)
                        @php
                            // IMAGE PRIORITY LOGIC
                            $gridImg = asset('assets/img/bg-masthead.webp');
                            if ($post->featured_image) {
                                $gridImg = Storage::url($post->featured_image);
                            } elseif ($post->coverPhoto) {
                                $gridImg = $post->coverPhoto->url;
                            } elseif ($post->gallery) {
                                $gridImg = $post->gallery->cover_photo_url;
                            }
                        @endphp

                        <div class="col-md-6 mb-5">
                            <div class="blog-card h-100">

                                {{-- Image Wrapper --}}
                                <div class="blog-img-wrapper grid-img-wrapper mb-4">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        <img src="{{ $gridImg }}" alt="{{ $post->title }}">
                                    </a>
                                </div>

                                {{-- Text Content --}}
                                <div class="text-uppercase text-white-50 small mb-2" style="letter-spacing: 1px;">
                                    {{ $post->published_at->format('F d, Y') }}
                                </div>
                                <h4 class="fw-bold mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-white text-decoration-none">{{ $post->title }}</a>
                                </h4>
                                <p class="text-white-50 small">
                                    {{ Str::limit(strip_tags($post->body), 120) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if(!$heroPost)
                <div class="text-center text-white-50 py-5" style="min-height: 50vh; display: flex; flex-direction: column; justify-content: center;">
                    <h2 class="text-white fw-bold">No posts found.</h2>
                    <p>Check back later!</p>
                </div>
            @endif

        </div>
    </section>
@endsection
