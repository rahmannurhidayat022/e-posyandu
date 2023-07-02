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
                                        <select class="select2 form-select" id="rt" name="rt" required>
                                            @for ($i = 1; $i <= 89; $i++) @php $formattedValue=str_pad($i, 2, '0' , STR_PAD_LEFT); @endphp <option value="{{ $formattedValue }}">RT {{ $formattedValue }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="rw">Rukun Warga (RW)</label>
                                        <select class="select2 form-select" id="rw" name="rw" required>
                                            @for ($i = 1; $i <= 14; $i++) @php $formattedValue=str_pad($i, 2, '0' , STR_PAD_LEFT); @endphp <option value="{{ $formattedValue }}">RW {{ $formattedValue }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h6><b>Pelayanan</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="posko_id">Posko</label>
                                        <select id="list-posko" class="select2 form-select" id="posko_id" name="posko_id" required>
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
