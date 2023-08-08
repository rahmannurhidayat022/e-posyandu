<!doctype html>
<html lang="en">

<head>
    <title>Posyandu Kebon Jayanti</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/posyandu.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery.min.css" integrity="sha512-F2E+YYE1gkt0T5TVajAslgDfTEUQKtlu4ralVq78ViNxhKXQLrgQLLie8u1tVdG2vWnB3ute4hcdbiBtvJQh0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery-bundle.min.css" integrity="sha512-nUqPe0+ak577sKSMThGcKJauRI7ENhKC2FQAOOmdyCYSrUh0GnwLsZNYqwilpMmplN+3nO3zso8CWUgu33BDag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm sticky-top bg-white">
        <div class="container">
            <a href="{{ route('home.index') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/posyandu.png') }}" width="50" alt="logo posyandu" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex align-items-center gap-3 ms-5">
                    <a class="nav-link text-uppercase {{ Route::currentRouteName() === 'home.index' ? 'text-info' : '' }}" href="{{ route('home.index') }}">Beranda</a>
                    <a class="nav-link text-uppercase {{ Route::currentRouteName() === 'artikel' ? 'text-info' : '' }}" href="{{ route('artikel') }}">Artikel</a>
                    <a class="nav-link text-uppercase {{ Route::currentRouteName() === 'galeri' ? 'text-info' : '' }}" href="{{ route('galeri') }}">Galeri</a>
                </div>
                @if (Auth::check())
                <a class="btn btn-primary ms-auto" href="{{ route('dashboard.index') }}">Dashboard</a>
                @else
                <a class="btn btn-primary ms-auto" href="{{ route('auth.index') }}">Login</a>
                @endif
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
    <footer>
        <div class="w-100 py-3 bg-dark text-center text-white">
            © 2023 - <strong>E-Posyandu Kebon Jayanti</strong>
        </div>
    </footer>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js" integrity="sha512-dSI4QnNeaXiNEjX2N8bkb16B7aMu/8SI5/rE6NIa3Hr/HnWUO+EAZpizN2JQJrXuvU7z0HTgpBVk/sfGd0oW+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gallery = document.querySelector('#gallery');

            lightGallery(gallery, {
                selector: '.fluidbox-item',
                download: false,
                counter: false,
                share: false,
                thumbnail: true
            });
        });
    </script>
</body>

</html>
