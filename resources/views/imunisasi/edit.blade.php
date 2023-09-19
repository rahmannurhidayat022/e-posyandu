@extends("layouts.admin")
@section("title", "Edit Data Imunisasi Anak")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('anak.index') }}">Kesehatan Anak</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('imunisasi.index', $id) }}">Imunisasi Anak</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-activity"></i>
                            </span>
                            Edit Data Imunisasi Anak <span class="badge rounded-pill text-bg-info">{{ $anak->nama }}</span>
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('imunisasi.update', $imunisasi->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row gap-0 row-gap-3 mb-3">
                                    <h6><b>Penimbangan</b></h6>
                                    <input type="text" value="{{ $id }}" name="anak_id" hidden>
                                    <input type="text" value="{{ Auth::user()->posko_id }}" name="posko_id" hidden>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="bulan">Usia (Bulan)</label>
                                        <input id="bulan" class="form-control form-sm" name="usia" type="number" value="{{ $imunisasi->usia }}">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="jenis_vaksin">Jenis Vaksin</label>
                                        <select id="jenis_vaksin" class="select2 form-control form-sm" name="jenis_vaksin" type="text"></select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="batch_number">Nomor Batch</label>
                                        <input id="batch_number" class="form-control" name="batch_number" type="number" value="{{ $imunisasi->batch_number }}" required>

                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="expired_date">Tanggal Kedaluarsa</label>
                                        <input id="expired_date" class="form-control" name="expired_date" type="date" value="{{ $imunisasi->expired_date }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h6><b>Tambahan</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="keluhan">Keluhan</label>
                                        <textarea id="keluhan" name="keluhan" class="form-control">{{ $imunisasi->keluhan }}</textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="catatan">Catatan</label>
                                        <textarea id="catatan" name="catatan" class="form-control">{{ $imunisasi->catatan }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h6><b>Petugas</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="petugas_id">Petugas Kesehatan</label>
                                        <select class="select2 form-select" id="petugas_id" name="petugas_id"></select>
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
            url: "{{ route('getPetugas') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '<option selected>Pilih</option>';
                $.each(response, function(index, data) {
                    let selected = '';
                    if (data.id == '{{ $imunisasi->petugas_id }}') {
                        selected = 'selected';
                    }
                    html += `<option value="${data.id}" ${selected}>${data.nama}</option>`
                });
                $('#petugas_id').html(html);
            }
        });
    });

    $(document).ready(function() {
        $.ajax({
            url: "{{ route('get-vaksin') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '<option selected>Pilih</option>';
                $.each(response, function(index, data) {
                    let selected = '';
                    if (data.name == '{{ $imunisasi->jenis_vaksin }}') {
                        selected = 'selected';
                    }
                    html += `<option value="${data.name}" ${selected}>${data.name}</option>`
                });
                $('#jenis_vaksin').html(html);
            }
        })
    });
</script>
@endpush
@endsection
