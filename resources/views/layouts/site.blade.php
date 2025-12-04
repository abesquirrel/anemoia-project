<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Anem[o]ia</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

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
        touchNavigation: true
    });
    // Auto-update Copyright Year
    document.getElementById('copyright-year').textContent = new Date().getFullYear();
</script>
<script>
    document.addEventListener('click', function(e) {
        let target = e.target.closest('a');

        // Only track valid links that aren't just anchor jumps (#)
        if (target) {
            let linkUrl = target.getAttribute('href');

            if (linkUrl && !linkUrl.startsWith('#') && !linkUrl.startsWith('javascript')) {
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
    });
</script>
</body>
</html>
