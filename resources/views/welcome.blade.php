@extends('layouts.site')

@section('title', 'Return to the Echoes | Anem[o]ia')
@section('description', 'Discover a collection of nostalgic, sepia-tinted photography exploring memory and time. Based in Sibiu, Romania.')

@section('content')

    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">Anem[o]ia</h1>
                    <h3 class="text-white-50 mx-auto mt-2 mb-5">"What we remember isn’t always <br> what happened, but what it felt like"</h3>
                    <a class="btn btn-primary" href="#about">Enter the Echoes</a>
                </div>
            </div>
        </div>
    </header>

    <section class="about-section text-center" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">What is Anemoia?</h2>
                    <p class="text-white-50">
                        Is the nostalgia for a time you've never known. Imagine stepping through the frame into a sepia-tinted haze, where you could sit on the side of the road and watch the locals passing by. Who lived and died before any of us arrived here,
                        who sleep in some of the same houses we do, who look up at the same moon, who breathe the same air, feel the same blood in their veins—and live in a completely different world.
                    </p>
                    <h2 class="text-white mb-4">Who am I</h2>
                    <p class="text-white-50">Honestly, I’m someone who holds onto moments a little too tightly, even the ones that aren’t mine. I have this habit of drifting into old memories, old feelings, old places I’ve never been. I notice the little echoes, the leftovers from lives before mine, the stories that hang in the air. Maybe it’s nostalgia, maybe it’s avoidance, maybe it’s just how my brain works. I move through today with pieces of yesterday clinging to me, sharing the sky with the people who came before. I guess I’m just trying to understand where I fit in all of this.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    @include('partials.gallery-section')

    <section class="contact-section bg-black" id="contact">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">BASED IN</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">Sibiu, Romania</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Email</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50"><a href="#!">anemoia@paulrojas.quest</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-mobile-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Phone</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">RO: +40 750 147 189</div>
                            <div class="small text-black-50">US: +1 (404) 599-3601</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social d-flex justify-content-center">
                <a class="mx-2" href="https://www.instagram.com/_henry.rojas_" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                <a class="mx-2" href="https://500px.com/p/PaulRojasPhotography?view=photos" target="_blank"><i class="fab fa-500px" aria-hidden="true"></i></a>
                <a class="mx-2" href="https://www.flickr.com/photos/193564586@N08/" target="_blank"><i class="fab fa-flickr" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>
@endsection
