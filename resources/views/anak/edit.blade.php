@extends("layouts.admin")
@section("title", "Edit Data Anak")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('anak.index') }}">Kesehatan Anak</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-baby-bottle"></i>
                            </span>
                            Edit Data Anak
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('anak.update', $anak->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row gap-0 row-gap-3 mb-3">
                                    <h6><b>Identitas Ibu</b></h6>
                                    <input type="text" value="{{ Auth::user()->posko_id }}" name="posko_id" hidden>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="nama">Nama Lengkap</label>
                                        <input id="nama" class="form-control form-sm" name="nama" type="text" value="{{ $anak->nama }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="nik">NIK</label>
                                        <input id="nik" class="form-control form-sm" name="nik" type="text" value="{{ $anak->nik }}">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                        <input id="tanggal_lahir" class="form-control form-sm" name="tanggal_lahir" type="date" value="{{ $anak->tanggal_lahir }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="lk" {{ $anak->jenis_kelamin == 'lk' ? 'selected' : ''}}>Laki-laki</option>
                                            <option value="pr" {{ $anak->jenis_kelamin == 'pr' ? 'selected' : ''}}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="ibu_id">Nama Ibu</label>
                                        <select class="select2 form-control" id="ibu_id" name="ibu_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h6><b>Pengecekan Kesehatan</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="posko_id">Posko</label>
                                        <select id="list-posko" class="form-select" id="posko_id" name="posko_id" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-4">
                                <button type="reset" class="btn btn-secondary disabled" data-bs-dismiss="modal" disabled>Reset</button>
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
                    let selected = '';
                    if (data.id == '{{ $anak->posko->id }}') {
                        selected = 'selected';
                    }
                    html += `<option value="${data.id}" ${selected}>RW ${data.rw} - ${data.nama}</option>`;
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
                    let selected = '';
                    if (data.id == '{{ $anak->ibu->id }}') {
                        selected = 'selected';
                    }
                    html += `<option value="${data.id}" ${selected}>${data.nama} / ${data.ayah}</option>`;
                });
                $('#ibu_id').html(html);
            }
        });
    });
</script>
@endpush
@endsection
