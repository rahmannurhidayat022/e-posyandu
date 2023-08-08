@extends('layouts.landing')
@section('content')
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
<section id="about" class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7">
                <h4 class="text-uppercase my-4 text-primary">Tentang Posyandu</h4>
                <p>
                    Posyandu di Kelurahan Kebon Jayanti adalah sebuah pusat pelayanan kesehatan masyarakat yang memberikan layanan kesehatan dasar kepada anak-anak, dan lansia. Posyandu merupakan singkatan dari Pos Pelayanan Terpadu, yang merupakan program yang dikembangkan oleh Kementerian Kesehatan Indonesia.
                </p>
                <p>Tujuan dari Posyandu di Kelurahan Kebon Jayanti adalah untuk meningkatkan kesehatan dan kesejahteraan masyarakat melalui pelayanan kesehatan, edukasi, dan pemantauan kondisi kesehatan anggota masyarakat.</p>
                <div class="d-flex flex-column gap-2 mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-scale-unbalanced"></i>
                        <span class="">Penimbangan Gizi Anak</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-syringe"></i>
                        <span class="">Imunisasi Anak</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-stethoscope"></i>
                        <span class="">Kesehatan Lansia</span>
                    </div>
                </div>
                <!-- <div class="d-flex gap-1 gap-md-4 flex-column flex-md-row align-items-center"> -->
                <!--     <a href="tel:+0227333054" class="nav-link text-info d-flex align-items-center justify-content-center gap-1"> -->
                <!--         <i class="bi bi-telephone fs-5 me-1"></i> -->
                <!--         (022) 7333054 -->
                <!--     </a> -->
                <!--     <a href="mailto:kebonjayantikirconbdg@gmail.com" class="nav-link text-info d-flex align-items-center justify-content-center gap-1"> -->
                <!--         <i class="bi bi-envelope fs-5 me-1"></i> -->
                <!--         kebonjayantikirconbdg@gmail.com -->
                <!--     </a> -->
                <!-- </div> -->
            </div>
            <div class="col-12 col-md-5">
                <div class="w-100 h-100 d-flex justify-content-center justify-content-md-end align-items-center overflow-hidden">
                    <img class="img-fluid" width="250" src="{{ asset('assets/images/posyandu.png') }}">
                </div>
            </div>
            <!-- <div class="col-12"> -->
            <!--     <div class="d-flex justify-content-center align-items-center gap-3 px-2 mt-5"> -->
            <!--         <div class="card" style="width: 100%; max-width: 200px; min-height: 170px"> -->
            <!--             <div class="card-body d-flex flex-column align-items-center justify-content-center gap-3"> -->
            <!--                 <i class="fa-solid fa-scale-unbalanced" style="font-size: 55px"></i> -->
            <!--                 <p class="text-center h6">Penimbangan Gizi Anak</p> -->
            <!--             </div> -->
            <!--         </div> -->
            <!--         <div class="card" style="width: 100%; max-width: 200px; min-height: 170px"> -->
            <!--             <div class="card-body">HII</div> -->
            <!--         </div> -->
            <!--         <div class="card" style="width: 100%; max-width: 200px; min-height: 170px"> -->
            <!--             <div class="card-body">HII</div> -->
            <!--         </div> -->
            <!--     </div> -->
            <!-- </div> -->
        </div>
    </div>
</section>
<section id="gallery" class="py-5">
    <div class="container">
        <h4 class="text-uppercase my-4 text-primary">Galeri Posyandu</h4>
        <div class="row g-2 mb-3">
            @foreach($galleries as $item)
            <div class="col-12 col-md-4">
                <div class="w-100 overflow-hidden">
                    <img class="fluidbox-item" src="{{ asset('storage/gallery/' . $item->image) }}" alt="{{ $item->image }}" style="width: 100%; height: 270px; object-fit: cover; object-position: center; cursor: pointer;">
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <a class="btn btn-outline-primary" href="{{ route('galeri') }}">
                Selengkapnya
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
<section id="article" class="py-5 bg-light">
    <div class="container">
        <h4 class="text-uppercase my-4 text-primary">Artikel</h4>
        <div class="row g-2 mb-3">
            @foreach($articles as $item)
            <div class="col-12 col-md-3">
                <a href="/artikel/{{ $item->slug }}" class="nav-link">
                    <div class="w-100 overflow-hidden">
                        <img class="fluidbox-item" src="{{ asset('storage/article/' . $item->image) }}" alt="{{ $item->image }}" style="width: 100%; height: 170px; object-fit: cover; object-position: center; cursor: pointer;">
                    </div>
                    <h5 class="h6 mt-2">{{ $item->title }}</h5>
                </a>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            <a class="btn btn-outline-primary" href="{{ route('artikel') }}">
                Selengkapnya
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endsection
