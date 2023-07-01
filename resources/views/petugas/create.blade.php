@extends("layouts.admin")
@section("title", "Create Petugas Kesehatan")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('petugas.index') }}">Petugas Kesehatan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-users"></i>
                            </span>
                            Tambah Data Petugas Kesehatan
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('petugas.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row gap-0 row-gap-3 mb-3">
                                    <h6><b>Identitas Petugas Kesehatan</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="nama">Nama Lengkap</label>
                                        <input id="nama" class="form-control form-sm" name="nama" type="text" value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="nik">NIK</label>
                                        <input id="nik" class="form-control form-sm" name="nik" type="text" value="{{ old('nik') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="telp">Telepon</label>
                                        <input id="telp" class="form-control form-sm" name="telp" type="tel" value="{{ old('telp') }}" required>
                                    </div>
                                </div>
                                <div class="row gap-0 row-gap-3 mb-3">
                                    <h6><b>Identitas Instansi</b></h6>
                                    <div class="mb-3">
                                        <label class="form-label" for="puskesmas">Puskesmas</label>
                                        <input id="puskesmas" class="form-control form" name="puskesmas" type="text" value="{{ old('puskesmas') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-4">
                                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('script')
@endpush
@endsection
