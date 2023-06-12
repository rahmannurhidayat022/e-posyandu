@extends("layouts.admin")
@section("title", "Create Admin Account")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('kader.index') }}">Kader</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-users"></i>
                            </span>
                            Tambah Data Kader
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('admin.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <h6><b>Pembuatan Akun</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input id="username" class="form-control form-sm" name="username" type="text" value="{{ old('username') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input id="password" class="form-control form-sm" name="password" type="password" min="6" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                        <input id="password_confirmation" class="form-control form-sm" name="password_confirmation" type="password" required>
                                    </div>

                                </div>
                                <div class="row gap-0 row-gap-3 mb-3">
                                    <h6><b>Identitas Kader</b></h6>
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
                                        <input id="telp" class="form-control form-sm" name="telp" type="text" value="{{ old('telp') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="jalan">Alamat (Jalan / Gang)</label>
                                        <input id="jalan" class="form-control" name="jalan" type="text" value="{{ old('jalan') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="rt">RT</label>
                                        <input id="rt" class="form-control form-sm" name="rt" type="text" value="{{ old('rt') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="rw">RW</label>
                                        <input id="rw" class="form-control form-sm" name="rw" type="text" value="{{ old('rw') }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h6><b>Pelayanan</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="posko_id">Posko</label>
                                        <select class="form-select" id="posko_id" name="posko_id" required>
                                            <option selected>Pilih</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="jabatan">Jabatan</label>
                                        <select class="form-select" id="jabatan" name="jabatan" required>
                                            <option selected>Pilih</option>
                                        </select>
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
