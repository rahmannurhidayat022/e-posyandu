@extends("layouts.admin")
@section("title", "Create Vaksin")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('vaksin.index') }}">Vaksin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-vaccine"></i>
                            </span>
                            Tambah Data Vaksin
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="form" method="post" action="{{ route('vaksin.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label" for="name">Nama Vaksin</label>
                                    <input id="name" class="form-control" name="name" type="text" value="{{ old('name') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="type">Jenis Vaksin</label>
                                    <input id="type" class="form-control" name="type" type="text" value="{{ old('type') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="variant">Varian Vaksin</label>
                                    <input id="variant" class="form-control" name="variant" type="text" value="{{ old('variant') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="batch_number">Nomor Batch</label>
                                    <input id="batch_number" class="form-control" name="batch_number" type="number" value="{{ old('batch_number') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="expired_date">Tanggal Kedaluarsa</label>
                                    <input id="expired_date" class="form-control" name="expired_date" type="date" value="{{ old('expired_date') }}" required>
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
