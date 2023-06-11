@extends("layouts.admin")
@section("title", "Create Posko")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-mailbox"></i>
                            </span>
                            Tambah Akun Admin
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="form" method="post" action="{{ route('posko.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label" for="nama">Nama Posko</label>
                                    <input id="nama" class="form-control" name="nama" type="text" value="{{ old('nama') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="jalan">Alamat (Jalan/gang)</label>
                                    <input id="jalan" class="form-control" name="jalan" type="text" value="{{ old('nama') }}" required>
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
                                <div class="mb-2">
                                    <label class="form-label" for="rt">Rukun Tetangga (RT)</label>
                                    <select class="select2 form-control" id="rt" name="rt[]" multiple="multiple">
                                        <option value="01">RT 01</option>
                                        <option value="02">RT 02</option>
                                        <option value="03">RT 03</option>
                                        <option value="04">RT 04</option>
                                        <option value="05">RT 06</option>
                                        <option value="07">RT 07</option>
                                        <option value="08">RT 08</option>
                                        <option value="09">RT 09</option>
                                        <option value="10">RT 10</option>
                                    </select>
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
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
@endsection
