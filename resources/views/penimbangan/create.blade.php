@extends("layouts.admin")
@section("title", "Tambah Data Penimbangan Anak")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('anak.index') }}">Kesehatan Anak</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penimbangan.index', $id) }}">Penimbangan Anak</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-activity"></i>
                            </span>
                            Tambah Data Penimbangan Anak <span class="badge rounded-pill text-bg-info">{{ $anak->nama }}</span>
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('penimbangan.store', $id) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row gap-0 row-gap-3 mb-3">
                                    <h6><b>Penimbangan</b></h6>
                                    <input type="text" value="{{ $id }}" name="anak_id" hidden>
                                    <input type="text" value="{{ session('user_information')->id }}" name="kader_id" hidden>
                                    <input type="text" value="{{ session('user_information')->posko->id }}" name="posko_id" hidden>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="bulan">Usia (Bulan)</label>
                                        <input id="bulan" class="form-control form-sm" name="usia" type="number" value="{{ $bulan }}" readonly>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="bb">Berat Badan (Kg)</label>
                                        <input id="bb" class="form-control form-sm" name="bb" type="number" value="{{ old('bb') }}" step="0.1" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="tb">Tinggi Badan (Cm)</label>
                                        <input id="tb" class="form-control form-sm" name="tb" type="number" value="{{ old('tb') }}" step="0.1" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h6><b>Tambahan</b></h6>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="keluhan">Keluhan</label>
                                        <textarea id="keluhan" name="keluhan" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label class="form-label" for="catatan">Catatan</label>
                                        <textarea id="catatan" name="catatan" class="form-control"></textarea>
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
            url: "{{ route('getAnak') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '<option selected>Pilih</option>';
                $.each(response, function(index, data) {
                    html += `<option value="${data.id}">${data.nama}</option>`
                });
                $('#anak_id').html(html);
            }
        });
        $.ajax({
            url: "{{ route('getKader') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '<option selected>Pilih</option>';
                $.each(response, function(index, data) {
                    html += `<option value="${data.id}">${data.nama}</option>`
                });
                $('#kader_id').html(html);
            }
        });
        $.ajax({
            url: "{{ route('getPetugas') }}",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let html = '<option selected>Pilih</option>';
                $.each(response, function(index, data) {
                    html += `<option value="${data.id}">${data.nama}</option>`
                });
                $('#petugas_id').html(html);
            }
        });
    });
</script>
@endpush
@endsection
