<!doctype html>
<html lang="en">

<head>
    <title>Posyandu Kebon Jayanti</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/posyandu.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
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
                <a class="btn btn-primary ms-auto" href="{{ route('auth.index') }}">Login</a>
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
                                <form>
                                    <div class="mb-3">
                                        <label class="form-label" for="nik">NIK / Nama Lengkap</label>
                                        <div class="d-flex gap-1 flex-nowrap">
                                            <input type="text" class="form-control" id="nik" name="nik">
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
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="mb-5">
                    <h4 class="text-uppercase my-4 text-primary text-center">Tentang Kami</h4>
                    <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="d-flex gap-4 flex-nowrap justify-content-center">
                        <a href="" class="nav-link text-info d-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-telephone fs-5 me-1"></i>
                            (022) 7333054
                        </a>
                        <a href="" class="nav-link text-info d-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-envelope fs-5 me-1"></i>
                            kebonjayantikirconbdg@gmail.com
                        </a>
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
</body>

</html>
