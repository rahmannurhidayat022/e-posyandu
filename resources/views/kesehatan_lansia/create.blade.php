@extends("layouts.admin")
@section("title", "Tambah Data Kesehatan Lansia")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('lansia.index') }}">Lansia</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('kesehatan_lansia.index', $id) }}">Kesehatan Lansia</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-activity"></i>
                            </span>
                            Tambah Data Cek Kesehatan Lansia <span class="badge rounded-pill text-bg-info">{{ $lansia->nama }}</span>
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('kesehatan_lansia.store', $id) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row gap-0 row-gap-3 mb-3">
                                    <h6><b>Penimbangan</b></h6>
                                    <input type="text" value="{{ $id }}" name="lansia_id" hidden>
                                    <input type="text" value="{{ session('user_information')->posko->id }}" name="posko_id" hidden>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="bb">Berat Badan (Kg)</label>
                                        <input id="bb" class="form-control form-sm" name="bb" type="number" value="{{ old('bb') }}" step="0.1" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="tb">Tinggi Badan (Cm)</label>
                                        <input id="tb" class="form-control form-sm" name="tb" type="number" value="{{ old('tb') }}" step="0.1" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="tekanan_darah">Tekanan Darah (mmHg)</label>
                                        <input id="tekanan_darah" class="form-control form-sm" name="tekanan_darah" type="text" value="{{ old('tekanan_darah') }}" step="0.1" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="kolestrol">Kolestrol (mg/dL)</label>
                                        <input id="kolestrol" class="form-control form-sm" name="kolestrol" type="text" value="{{ old('kolestrol') }}" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="form-label" for="gula_darah">Gula Darah (mg/dL)</label>
                                        <input id="gula_darah" class="form-control form-sm" name="gula_darah" type="text" value="{{ old('gula_darah') }}" required>
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
