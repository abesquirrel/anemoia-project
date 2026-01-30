<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'Anem[o]ia - Nostalgic Photography')</title>
    <meta name="description" content="@yield('description', 'Stepping through the frame into a sepia-tinted haze. Fine art photography based in Sibiu, Romania.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og:type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Anem[o]ia - Nostalgic Photography')">
    <meta property="og:description" content="@yield('description', 'Stepping through the frame into a sepia-tinted haze. Fine art photography based in Sibiu, Romania.')">
    <meta property="og:image" content="@yield('og:image', asset('assets/img/og-default.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Anem[o]ia - Nostalgic Photography')">
    <meta property="twitter:description" content="@yield('description', 'Stepping through the frame into a sepia-tinted haze. Fine art photography based in Sibiu, Romania.')">
    <meta property="twitter:image" content="@yield('og:image', asset('assets/img/og-default.jpg'))">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    
    <style>
        /* Custom GLightbox Description Styling for EXIF Data */
        .gslide-description {
            background: rgba(0, 0, 0, 0.75) !important; /* Increased transparency */
            padding: 0.5rem 2rem 2.5rem 2rem !important; /* Reduced top, Increased bottom */
            font-family: 'Varela Round', sans-serif !important;
            font-size: 1.1rem !important;
            letter-spacing: 0.8px !important;
            color: #e8e8e8 !important;
            border-top: 2px solid #64a19d !important;
            text-align: center !important;
            backdrop-filter: blur(3px); /* Subtle blur for better legibility */
        }

        /* Mobile Optimization */
        @media (max-width: 768px) {
            .gslide-description {
                padding: 0.5rem 1rem 2rem 1rem !important;
                font-size: 0.9rem !important;
            }
        }
        
        .gslide-description .exif-data {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping on small screens */
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            line-height: 1.4;
        }
        
        .gslide-description .exif-data i {
            color: #64a19d;
            margin-right: 0.25rem;
            font-size: 0.9em;
        }
        
        .gslide-description .separator {
            color: #64a19d;
            margin: 0 0.5rem;
            font-weight: 300;
        }
        
        /* Custom slide counter styling - subtle bottom placement */
        .gslide-count {
            position: absolute !important;
            bottom: 1rem !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            background: rgba(0, 0, 0, 0.5) !important;
            color: rgba(232, 232, 232, 0.6) !important;
            padding: 0.35rem 1rem !important;
            border-radius: 1rem !important;
            font-family: 'Varela Round', sans-serif !important;
            font-size: 0.8rem !important;
            letter-spacing: 1px !important;
            border: 1px solid rgba(100, 161, 157, 0.15) !important;
            z-index: 9999 !important;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .gslide-count:hover {
            opacity: 1;
        }
        
        .gslide-count .separator {
            margin: 0 0.4rem;
            color: rgba(100, 161, 157, 0.5);
        }
    </style>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SVWCRBLWG4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-SVWCRBLWG4');
    </script>
</head>
<body id="page-top">

<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('home') }}#page-top">Anem[o]ia</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#gallery">Gallery</a></li>
                {{-- NEW: Journal (Blog) Link --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Journal</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer class="footer bg-black small text-center text-white-50">
    <div class="container px-4 px-lg-5">Copyright &copy; Anem[o]ia <span id="copyright-year"></span></div>
</footer>

<script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({
        selector: '.g-lightbox',
        loop: true,
        touchNavigation: true,
        descPosition: 'bottom'
    });

    // GLightbox Analytics & Custom Counter
    if (typeof lightbox !== 'undefined') {
        lightbox.on('open', () => {
            gtag('event', 'lightbox_open', {
                'event_category': 'gallery',
                'event_label': 'Lightbox Opened'
            });
            
            // Add custom counter on open (with slight delay for DOM to be ready)
            setTimeout(updateSlideCounter, 100);
        });

        lightbox.on('slide_changed', ({ prev, current }) => {
            gtag('event', 'lightbox_slide', {
                'event_category': 'gallery',
                'event_label': 'Slide Changed'
            });
            
            // Update custom counter
            setTimeout(updateSlideCounter, 50);
        });
    }
    
    function updateSlideCounter() {
        // Remove existing counter
        const existingCounter = document.querySelector('.gslide-count');
        if (existingCounter) {
            existingCounter.remove();
        }
        
        // Get the lightbox wrapper
        const glightbox = document.querySelector('.glightbox-container');
        if (!glightbox) return;
        
        // Get active slide
        const activeSlide = glightbox.querySelector('.gslide.current');
        if (!activeSlide) return;
        
        // Get all slides
        const allSlides = glightbox.querySelectorAll('.gslide');
        const currentIndex = Array.from(allSlides).indexOf(activeSlide);
        
        if (currentIndex === -1 || allSlides.length === 0) return;
        
        // Create counter element
        const counter = document.createElement('div');
        counter.className = 'gslide-count';
        counter.innerHTML = `${currentIndex + 1} <span class="separator">•</span> ${allSlides.length}`;
        
        // Add to glightbox container (not individual slide)
        glightbox.appendChild(counter);
    }

    // Auto-update Copyright Year
    document.getElementById('copyright-year').textContent = new Date().getFullYear();
</script>
<script>
    // General Analytics Tracking (Scroll & Clicks)
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Scroll Depth Tracking
        let scrollDepths = { 25: false, 50: false, 75: false, 90: false };

        const trackScroll = () => {
            const scrollTop = window.scrollY;
            const docHeight = document.body.offsetHeight;
            const winHeight = window.innerHeight;

            if (docHeight <= winHeight) return; // Not enough content to scroll

            const scrollPercent = Math.round((scrollTop / (docHeight - winHeight)) * 100);

            for (let depth in scrollDepths) {
                if (!scrollDepths[depth] && scrollPercent >= depth) {
                    scrollDepths[depth] = true;
                    gtag('event', 'scroll_depth', {
                        'event_category': 'engagement',
                        'event_label': depth + '%',
                        'value': parseInt(depth)
                    });
                }
            }
        };

        document.addEventListener('scroll', trackScroll);
    });

    document.addEventListener('click', function(e) {
        let target = e.target.closest('a');

        // Only track valid links that aren't just anchor jumps (#)
        if (target) {
            let linkUrl = target.getAttribute('href');

            if (linkUrl) {
                // 2. Outbound & Contact Link Tracking
                if (linkUrl.startsWith('mailto:')) {
                    gtag('event', 'contact_click', {
                        'event_category': 'contact',
                        'event_label': 'Email: ' + linkUrl.replace('mailto:', '')
                    });
                } else if (linkUrl.startsWith('tel:')) {
                     gtag('event', 'contact_click', {
                        'event_category': 'contact',
                        'event_label': 'Phone: ' + linkUrl.replace('tel:', '')
                    });
                } else if (linkUrl.startsWith('http') && !linkUrl.includes(window.location.hostname)) {
                    gtag('event', 'outbound_click', {
                        'event_category': 'outbound',
                        'event_label': linkUrl,
                        'transport_type': 'beacon'
                    });
                }

                // Existing Internal Logging
                if (!linkUrl.startsWith('#') && !linkUrl.startsWith('javascript')) {
                    fetch('{{ route('log.event') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel security token
                        },
                        body: JSON.stringify({
                            type: 'click',
                            message: 'User clicked link: ' + linkUrl
                        })
                    });
                }
            }
        }
    });
</script>
@stack('scripts')
</body>
</html>
