<section class="projects-section bg-light" id="gallery">
    <div class="container px-4 px-lg-5">

        <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
            <div class="col-xl-8 col-lg-7"><img class="img-fluid img-thumbnail mb-3 mb-lg-0" src="{{ asset('assets/img/bg-masthead.webp') }}" alt="..." /></div>
            <div class="col-xl-4 col-lg-5">
                <div class="featured-text text-center text-lg-left">
                    <h4>Resonating echos...</h4>
                    <p class="text-black-50 mb-0">...from a distant memory</p>
                </div>
            </div>
        </div>
        @if($featured_gallery_a)
            @php $coverUrl_A = $featured_gallery_a->cover_photo_url; @endphp
            <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
                <div class="col-lg-6">
                    <a class="g-lightbox" data-gallery="gallery{{ $featured_gallery_a->id }}" href="{{ $coverUrl_A }}">
                        <img class="img-thumbnail img-fluid photo-container" src="{{ $coverUrl_A }}" alt="{{ $featured_gallery_a->title }}">
                    </a>

                    @foreach($featured_gallery_a->photos as $photo)
                        @if($photo->url !== $coverUrl_A)
                            <a class="g-lightbox d-none" data-gallery="gallery{{ $featured_gallery_a->id }}" href="{{ $photo->url }}"></a>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-6">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-left">
                                <h4 class="text-white">{{ $featured_gallery_a->title }}</h4>
                                <p class="mb-0 text-white-50">{{ $featured_gallery_a->camera }}</p>
                                <p class="mb-0 text-white-50">{{ $featured_gallery_a->film }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($featured_gallery_b)
            @php $coverUrl_B = $featured_gallery_b->cover_photo_url; @endphp
            <div class="row gx-0 justify-content-center">
                <div class="col-lg-6">
                    <a class="g-lightbox" data-gallery="gallery{{ $featured_gallery_b->id }}" href="{{ $coverUrl_B }}">
                        <img class="img-thumbnail img-fluid photo-container" src="{{ $coverUrl_B }}" alt="{{ $featured_gallery_b->title }}">
                    </a>

                    @foreach($featured_gallery_b->photos as $photo)
                        @if($photo->url !== $coverUrl_B)
                            <a class="g-lightbox d-none" data-gallery="gallery{{ $featured_gallery_b->id }}" href="{{ $photo->url }}"></a>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-6 order-lg-first">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-right">
                                <h4 class="text-white">{{ $featured_gallery_b->title }}</h4>
                                <p class="mb-0 text-white-50">{{ $featured_gallery_b->camera }}</p>
                                <p class="mb-0 text-white-50">{{ $featured_gallery_b->film }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="container px-4 px-lg-0 p-5">
            <h2 class="text-black-100 text-center mb-5">Fragments of reminiscence</h2>
            <div class="row">
                @forelse ($grid_galleries as $gallery)
                    <div class="col-md-4">
                        <div class="card mb-lg-2">
                            @php $coverUrl_Grid = $gallery->cover_photo_url; @endphp

                            <a class="g-lightbox" data-gallery="gallery_{{ $gallery->id }}" href="{{ $coverUrl_Grid }}">
                                <img class="img-fluid img-thumbnail card-img-top photo-container" src="{{ $coverUrl_Grid }}" alt="{{ $gallery->title }}">
                            </a>

                            @foreach($gallery->photos as $photo)
                                @if($photo->url !== $coverUrl_Grid)
                                    {{-- THIS IS THE FIX: 'classs' is now 'class' --}}
                                    <a class="g-lightbox d-none" data-gallery="gallery_{{ $gallery->id }}" href="{{ $photo->url }}"></a>
                                @endif
                            @endforeach

                            <div class="card-body bg-black">
                                <h5 class="card-title text-white text-center card-text-limit">{{ $gallery->title }}</h5>
                                <p class="card-text mb-0 text-white-50 text-center card-text-limit">{{ $gallery->film }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No galleries have been added yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
