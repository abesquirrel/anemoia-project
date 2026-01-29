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
            background: rgba(0, 0, 0, 0.85) !important;
            padding: 1rem 1.5rem !important;
            font-family: 'Varela Round', sans-serif !important;
            font-size: 0.95rem !important;
            letter-spacing: 0.5px !important;
            color: #e0e0e0 !important;
            border-top: 2px solid #64a19d !important;
            text-align: center !important;
        }
        
        .gdesc-inner {
            max-width: 600px;
            margin: 0 auto;
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

    // GLightbox Analytics
    if (typeof lightbox !== 'undefined') {
        lightbox.on('open', () => {
            gtag('event', 'lightbox_open', {
                'event_category': 'gallery',
                'event_label': 'Lightbox Opened'
            });
        });

        lightbox.on('slide_changed', ({ prev, current }) => {
            gtag('event', 'lightbox_slide', {
                'event_category': 'gallery',
                'event_label': 'Slide Changed'
            });
        });
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
