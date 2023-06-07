@extends("layouts.admin")
@section("title", "Dashboard")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Posko Pelayanan Posyandu</h2>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addPosko">
                        <i class="ti ti-pencil-plus"></i>
                        Tambah Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPosko" tabindex="-1" aria-labelledby="addPosko" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex gap-2 align-items-center">
                    <div class="badge-circle">
                        <i class="ti ti-mailbox"></i>
                    </div>
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Input Data Posko Baru
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('posko.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label" for="nama">Nama Posko</label>
                            <input id="nama" class="form-control" name="nama" type="text" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="jalan">Alamat (Jalan/gang)</label>
                            <input id="jalan" class="form-control" name="jalan" type="text" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="rw">Rukun Warga (RW)</label>
                            <select class="form-select" id="rw" name="rw" required>
                                <option value="01" selected>RW 01</option>
                                <option value="02">RW 02</option>
                                <option value="03">RW 03</option>
                                <option value="04">RW 04</option>
                                <option value="05">RW 06</option>
                                <option value="07">RW 07</option>
                                <option value="08">RW 08</option>
                                <option value="09">RW 09</option>
                                <option value="10">RW 10</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
