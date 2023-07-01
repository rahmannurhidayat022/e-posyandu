@extends("layouts.admin")
@section("title", "Create Kader Account")
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
                                <i class="ti ti-heart-handshake"></i>
                            </span>
                            Tambah Data Kader
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('kader.store') }}">
                            @csrf
                            <div class="modal-body">
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
                                        <label class="form-label" for="rt">Rukun Tetangga (RT)</label>
                                        <select class="form-select" id="rt" name="rt">
                                            <option value="01" selected>RT 01</option>
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
                                    <div class="col-sm-12 col-md-6 col-lg-3">
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
                                            <option value="11">RW 11</option>
                                            <option value="12">RW 12</option>
                                            <option value="13">RW 13</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h6><b>Pelayanan</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="posko_id">Posko</label>
                                        <select id="list-posko" class="form-select" id="posko_id" name="posko_id" required>
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
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('getPosko') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '<option selected>Pilih</option>';
                $.each(response, function(index, data) {
                    html += `<option value="${data.id}">RW ${data.rw} - ${data.nama}</option>`
                });
                $('#list-posko').html(html);
            }
        })
    });
</script>
@endpush
@endsection
