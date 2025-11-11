<section class="projects-section bg-light" id="gallery">
    <div class="container px-4 px-lg-5">

        <!-- Featured Photo Row (from gallery.php) -->
        <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
            <div class="col-xl-8 col-lg-7"><img class="img-fluid img-thumbnail mb-3 mb-lg-0" src="{{ asset('assets/img/bg-masthead.jpg') }}" alt="..." /></div>
            <div class="col-xl-4 col-lg-5">
                <div class="featured-text text-center text-lg-left">
                    <h4>Resonating echos...</h4>
                    <p class="text-black-50 mb-0">...from a distant memory</p>
                </div>
            </div>
        </div>
        <!-- Featured Photo Row End -->

        <!-- Featured Gallery 1 (From Controller $featured_gallery_1) -->
        {{-- This @if check now prevents errors if the gallery is null --}}
        @if($featured_gallery_1)
            <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
                <div class="col-lg-6">
                    <a class="venobox" data-gall="gallery{{ $featured_gallery_1->id }}" href="{{ $featured_gallery_1->cover_photo_url }}">
                        <img class="img-thumbnail img-fluid photo-container" src="{{ $featured_gallery_1->cover_photo_url }}" alt="{{ $featured_gallery_1->title }}">
                    </a>
                    @foreach($featured_gallery_1->photos->skip(1) as $photo)
                        <a class="venobox d-none" data-gall="gallery{{ $featured_gallery_1->id }}" href="{{ $photo->url }}"></a>
                    @endforeach
                </div>
                <div class="col-lg-6">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-left">
                                <h4 class="text-white">{{ $featured_gallery_1->title }}</h4>
                                <p class="mb-0 text-white-50">{{ $featured_gallery_1->camera }}</p>
                                <p class="mb-0 text-white-50">{{ $featured_gallery_1->film }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Featured Gallery 1 End -->

        <!-- Featured Gallery 2 (From Controller $featured_gallery_2) -->
        @if($featured_gallery_2)
            <div class="row gx-0 justify-content-center">
                <div class="col-lg-6">
                    <a class="venobox" data-gall="gallery{{ $featured_gallery_2->id }}" href="{{ $featured_gallery_2->cover_photo_url }}">
                        <img class="img-thumbnail img-fluid photo-container" src="{{ $featured_gallery_2->cover_photo_url }}" alt="{{ $featured_gallery_2->title }}">
                    </a>
                    @foreach($featured_gallery_2->photos->skip(1) as $photo)
                        <a class="venobox d-none" data-gall="gallery{{ $featured_gallery_2->id }}" href="{{ $photo->url }}"></a>
                    @endforeach
                </div>
                <div class="col-lg-6 order-lg-first">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-right">
                                <h4 class="text-white">{{ $featured_gallery_2->title }}</h4>
                                <p class="mb-0 text-white-50">{{ $featured_gallery_2->camera }}</p>
                                <p class="mb-0 text-white-50">{{ $featured_gallery_2->film }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Featured Gallery 2 End -->


        <!-- Galleries Grid (from $grid_galleries) -->
        <div class="container px-4 px-lg-0 p-5">
            <h2 class="text-black-100 text-center mb-5">Fragments of reminiscence</h2>
            <div class="row">
                {{-- @forelse handles the case where $grid_galleries is empty --}}
                @forelse ($grid_galleries as $gallery)
                    <div class="col-md-4">
                        <div class="card mb-lg-2">
                            <a class="venobox" data-gall="gallery_{{ $gallery->id }}" href="{{ $gallery->cover_photo_url }}">
                                <img class="img-fluid img-thumbnail card-img-top photo-container" src="{{ $gallery->cover_photo_url }}" alt="{{ $gallery->title }}">
                            </a>
                            @foreach($gallery->photos->skip(1) as $photo)
                                <a class="venobox d-none" data-gall="gallery_{{ $gallery->id }}" href="{{ $photo->url }}"></a>
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
        <!-- Galleries Grid End -->

    </div>
</section>
