<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Anem[o]ia</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />

        <link href="{{ asset('vendor/venebox/venebox.css') }}" rel="stylesheet" />

        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    </head>
    <body id="page-top">

        {{-- This is where our page content will go --}}
        @yield('content')

        <footer class="footer bg-black small text-center text-white-50">
            <div class="container px-4 px-lg-5">Copyright &copy; Anem[o]ia <span id="copyright-year"></span></div>
        </footer>

        <script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/js/font_awesome_all.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('vendor/venebox/venebox.js') }}"></script>
        <script src="{{ asset('js/venebox-utils.js') }}"></script>

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-6JPNPWF3ZJ"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-6JPNPWF3ZJ');
        </script>
    </body>
</html>
