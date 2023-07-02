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
                            <li class="breadcrumb-item"><a href="{{ route('posko.index') }}">Posko</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-mailbox"></i>
                            </span>
                            Tambah Data Posko
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
                                    <select class="select2 form-select" id="rw" name="rw" required>
                                        @for ($i = 1; $i <= 14; $i++) @php $formattedValue=str_pad($i, 2, '0' , STR_PAD_LEFT); @endphp <option value="{{ $formattedValue }}">RW {{ $formattedValue }}</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="rt">Lingkup Rukun Tetangga (RT)</label>
                                    <select class="select2 form-select" id="rt" name="rt[]" multiple="multiple">
                                        @for ($i = 1; $i <= 89; $i++) @php $formattedValue=str_pad($i, 2, '0' , STR_PAD_LEFT); @endphp <option value="{{ $formattedValue }}">RT {{ $formattedValue }}</option>
                                            @endfor
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
@endpush
@endsection
