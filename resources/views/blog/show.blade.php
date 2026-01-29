{{-- File: resources/views/blog/show.blade.php --}}
@extends('layouts.site')

@section('title', $post->title . ' | Anem[o]ia Journal')
@section('description', Str::limit(strip_tags($post->content), 160))
@section('og:type', 'article')
@section('og:image', $post->featured_image_url ?: ($post->coverPhoto ? $post->coverPhoto->url : asset('assets/img/og-default.jpg')))

@section('content')

    <style>
        /* --- LAYOUT & HEADER --- */
        .article-header {
            position: relative;
            height: 65vh;
            min-height: 450px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center; /* Center vertically */
            justify-content: center;
        }

        /* Gradient overlay to ensure text pop */
        .article-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), #000000);
        }

        .header-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 900px;
            padding: 0 20px;
        }

        /* --- TYPOGRAPHY (Using Site Defaults) --- */
        .article-title {
            /* Using theme font (Varela Round usually) */
            font-family: inherit;
            font-weight: 800;
            font-size: clamp(2.5rem, 5vw, 4.5rem); /* Responsive sizing */
            line-height: 1.1;
            color: white;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .article-meta {
            font-family: inherit;
            text-transform: uppercase;
            letter-spacing: 4px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
            border: 1px solid rgba(255,255,255,0.3);
            display: inline-block;
            padding: 8px 24px;
            border-radius: 50px;
        }

        /* --- READABILITY CORE --- */
        .article-container {
            background-color: #000;
            padding-bottom: 6rem;
        }

        .article-body {
            /* Inherit site font (Nunito) but style for reading */
            font-family: inherit;
            font-size: 1.2rem;      /* Slightly larger than standard */
            line-height: 1.8;       /* Open line height for breathing room */
            color: #d1d5db;         /* Light Gray (easier on eyes than pure white) */

            /* THE GOLDEN RULE OF READABILITY: Max width 680-750px */
            max-width: 700px;
            margin: 0 auto;         /* Center the column */
            font-weight: 300;       /* Light weight looks elegant in dark mode */
        }

        .article-body p {
            margin-bottom: 2rem; /* generous spacing between paragraphs */
        }

        /* Styled First Letter (Drop Cap - Sans Serif Style) */
        .article-body p:first-of-type::first-letter {
            font-weight: 800;
            float: left;
            font-size: 4rem;
            line-height: 0.8;
            margin-right: 1rem;
            color: white;
        }

        /* --- GALLERY CARD --- */
        .gallery-link-card {
            background: #111;
            border: 1px solid #222;
            max-width: 800px;
            margin: 5rem auto 0;
            transition: transform 0.3s;
        }
        .gallery-link-card:hover {
            border-color: #444;
            transform: translateY(-5px);
        }
    </style>

    @php
        // IMAGE PRIORITY LOGIC (Matches Index Page)
        // Start with default fallback
        $bgImage = asset('assets/img/bg-masthead.webp');

        if ($post->featured_image) {
            // 1. Priority: Custom Uploaded Image
            $bgImage = $post->featured_image_url;
        } elseif ($post->coverPhoto) {
            // 2. Priority: Specific Selected Photo from Album
            $bgImage = $post->coverPhoto->url;
        } elseif ($post->gallery) {
            // 3. Priority: Album's General Cover Photo
            $bgImage = $post->gallery->cover_photo_url;
        }
    @endphp

    <header class="article-header" style="background-image: url('{{ $bgImage }}')">
        <div class="article-overlay"></div>
        <div class="header-content">
            <div class="article-meta">
                {{ $post->published_at->format('F d, Y') }}
            </div>
            <h1 class="article-title">{{ $post->title }}</h1>
            <div class="text-white-50" style="letter-spacing: 2px; font-size: 0.9rem;">
                WORDS BY {{ strtoupper($post->user->name) }}
            </div>
        </div>
    </header>

    <section class="article-container">
        <div class="container px-4">

            <div class="article-body">
                {!! nl2br(e($post->body)) !!}
            </div>

            @if($post->gallery)
                <div class="card gallery-link-card">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <img src="{{ $post->gallery->cover_photo_url }}" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 300px;" alt="{{ $post->gallery->title }}">
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5">
                                <h6 class="text-uppercase text-secondary mb-2" style="letter-spacing: 2px; font-size: 0.7rem;">Visual Story</h6>
                                <h3 class="text-white mb-3" style="text-transform: uppercase;">{{ $post->gallery->title }}</h3>
                                <p class="text-white-50 mb-4 small">
                                    {{ Str::limit($post->gallery->description, 100) }}
                                </p>

                                <a href="{{ $post->gallery->cover_photo_url }}" class="g-lightbox btn btn-outline-light rounded-0 text-uppercase" style="letter-spacing: 2px;" data-gallery="post-gallery-{{ $post->gallery->id }}">
                                    Open Gallery
                                </a>

                                {{-- Hidden links --}}
                                @foreach($post->gallery->photos as $photo)
                                    @if($photo->url !== $post->gallery->cover_photo_url && $photo->is_visible)
                                        <a href="{{ $photo->url }}" class="g-lightbox d-none" data-gallery="post-gallery-{{ $post->gallery->id }}"></a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-center mt-5 pt-5">
                <a href="{{ route('blog.index') }}" class="text-white-50 text-decoration-none text-uppercase small" style="letter-spacing: 3px; transition: color 0.3s;">
                    &larr; Back to Journal
                </a>
            </div>

        </div>
    </section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gtag === 'function') {
                gtag('event', 'view_item', {
                    "items": [
                        {
                            "item_id": "{{ $post->id }}",
                            "item_name": "{{ $post->title }}",
                            "item_category": "Blog Post",
                            "author": "{{ $post->user ? $post->user->name : 'Anemoia' }}"
                        }
                    ]
                });
            }
        });
    </script>
@endpush
@endsection
