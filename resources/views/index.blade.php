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
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a href="{{ route('home.index') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/posyandu.png') }}" width="50" alt="logo posyandu" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-flex gap-2"> -->
                <!--     <li class="nav-item"> -->
                <!--         <a class="nav-link" href="#">Tenang Kami</a> -->
                <!--     </li> -->
                <!-- </ul> -->
                @if (Auth::check())
                <a class="btn btn-primary ms-auto" href="{{ route('dashboard.index') }}">Dashboard</a>
                @else
                <a class="btn btn-primary ms-auto" href="{{ route('auth.index') }}">Login</a>
                @endif
            </div>
        </div>
    </nav>
    <main>
        <section>
            <div class="container">
                <div class="row py-5">
                    <div class="col-12 col-md-5 d-flex align-items-center mb-4 mb-md-0">
                        <img class="d-block mx-auto" src="{{ asset('assets/images/family-icon.svg') }}" alt="family icon">
                    </div>
                    <div class="col-12 col-md-7">
                        <h4 class="text-uppercase mb-4 text-primary">Posyandu Kelurahan Kebon Jayanti</h4>
                        <div class="card" style="border: none">
                            <div class="card-header" style="border: none">
                                <h6 class="card-title text-uppercase"><i class="bi bi-clipboard2-pulse fs-4 me-1"></i> Cek perkembangan anak</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('home.index') }}" method="GET">
                                    <div class="mb-3">
                                        <label class="form-label" for="nik">NIK / Nama Lengkap</label>
                                        <div class="d-flex gap-1 flex-nowrap">
                                            <input type="text" class="form-control" id="nik" name="search">
                                            <button type="reset" class="btn btn-sm btn-danger"><i class="bi bi-x fs-5"></i></button>
                                            <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                                        </div>
                                        <sub class="text-info">**rekomendasi menggunakan NIK agar lebih akurat</sub>
                                    </div>
                                </form>
                                @if (session('error'))
                                <p class="mb-1">Hasil:</p>
                                <div class="alert alert-danger">Data tidak ditemukan.</div>
                                @endif
                                @if (session('success'))
                                <label class="form-label mb-1">Hasil:</label>
                                <div classs="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('success') as $item)
                                            <tr>
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>
                                                    <a href="{{ route('home.kms', $item->id) }}" class="btn btn-sm btn-outline-primary">KMS</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ session('success')->links() }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="about">
            <div class="container">
                <div class="mb-5">
                    <h4 class="text-uppercase my-4 text-primary text-center">Tentang Kami</h4>
                    <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="d-flex gap-1 gap-md-4 flex-column flex-md-row justify-content-center">
                        <a href="tel:+0227333054" class="nav-link text-info d-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-telephone fs-5 me-1"></i>
                            (022) 7333054
                        </a>
                        <a href="mailto:kebonjayantikirconbdg@gmail.com" class="nav-link text-info d-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-envelope fs-5 me-1"></i>
                            kebonjayantikirconbdg@gmail.com
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="gallery">
            <div class="container">
                <div class="gallery">
                    <div class="gallery-item">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-01.jpg') }}" alt="gallery-01">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-02.jpg') }}" alt="gallery-02">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-03.jpg') }}" alt="gallery-03">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-10.jpg') }}" alt="gallery-10">
                    </div>
                    <div class="gallery-item">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-04.jpg') }}" alt="gallery-04">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-05.jpg') }}" alt="gallery-05">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-06.jpg') }}" alt="gallery-06">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-11.jpg') }}" alt="gallery-11">
                    </div>
                    <div class="gallery-item">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-07.jpg') }}" alt="gallery-07">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-08.jpg') }}" alt="gallery-08">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-09.jpg') }}" alt="gallery-09">
                        <img class="fluidbox-item" src="{{ asset('assets/images/gallery-12.jpg') }}" alt="gallery-12">
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="text-center my-4">
        © 2023 - <strong>E-Posyandu Kebon Jayanti
    </footer>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js" integrity="sha512-dSI4QnNeaXiNEjX2N8bkb16B7aMu/8SI5/rE6NIa3Hr/HnWUO+EAZpizN2JQJrXuvU7z0HTgpBVk/sfGd0oW+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gallery = document.querySelector('.gallery');

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
