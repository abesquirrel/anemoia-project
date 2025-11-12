@extends('layouts.site')

@section('content')
    <header class="masthead" style="background-image: url('{{ asset('assets/img/bg-masthead.jpg') }}')">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">The Blog</h1>
                </div>
            </div>
        </div>
    </header>

    <section class="about-section text-center" id="blog-list">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-10">

                    @forelse ($posts as $post)
                        <div class="card text-start bg-light mb-4">
                            <div class="card-body">
                                <h2 class="card-title">{{ $post->title }}</h2>
                                <p class="text-muted small">
                                    By {{ $post->user->name }} on {{ $post->published_at->format('F d, Y') }}
                                </p>

                                {{-- Show a snippet --}}
                                <p class="card-text">{{ Str::limit(strip_tags($post->body), 150) }}</p>

                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-white-50">
                            <h2 class="text-white mb-4">No posts found.</h2>
                            <p>Check back later!</p>
                        </div>
                    @endforelse

                    <div class="d-flex justify-content-center mt-4">
                        {{ $posts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
