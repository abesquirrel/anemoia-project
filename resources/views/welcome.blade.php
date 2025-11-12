{{-- Use our new 'site' layout --}}
@extends('layouts.site')

@section('content')

    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">Anem[o]ia</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">Anem[o]ia</h1>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">"The past is a foreign country: they do things differently there" <br> – L.P. Hartley</h2>
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
                    <p class="text-white-50">A lover of memories, seeking moments beyond their era. Dwelling in sepia-tinted dreams, I'm an observer of the past. Amid nostalgia, I watch phantom lives, echoes of laughter and forgotten stories. Sharing the moon's glow with past wanderers, I breathe the same breeze, part of a different world's tapestry.</p>
                </div>
            </div>
        </div>
    </section>

    {{--
      This is the dynamic gallery section.
      We'll create this as a separate "partial" file to keep things clean.
    --}}
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
