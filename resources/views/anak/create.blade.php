@extends("layouts.admin")
@section("title", "Tambah Data Anak")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('anak.index') }}">Kesehatan anak</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-baby-bottle"></i>
                            </span>
                            Tambah Data Anak
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('anak.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row gap-0 row-gap-3 mb-3">
                                    <h6><b>Identitas Anak</b></h6>
                                    <input type="text" value="{{ Auth::user()->posko_id }}" name="posko_id" hidden>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="nama">Nama Lengkap</label>
                                        <input id="nama" class="form-control form-sm" name="nama" type="text" value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="nik">NIK</label>
                                        <input id="nik" class="form-control form-sm" name="nik" type="text" value="{{ old('nik') }}">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                        <input id="tanggal_lahir" class="form-control form-sm" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="lk" selected>Laki-laki</option>
                                            <option value="pr">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-5">
                                        <label class="form-label" for="ibu_id">Nama Ibu</label>
                                        <select class="select2 form-control" id="ibu_id" name="ibu_id">
                                        </select>
                                        <small>Data ibu tidak ditemukan? <a href="{{ route('ibu.create') }}">tambah</a></small>
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
        });
        $.ajax({
            url: "{{ route('getIbu') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '<option selected>Pilih</option>';
                $.each(response, function(index, data) {
                    html += `<option value="${data.id}">${data.nama} / ${data.ayah}</option>`
                });
                $('#ibu_id').html(html);
            }
        });
    });
</script>
@endpush
@endsection
