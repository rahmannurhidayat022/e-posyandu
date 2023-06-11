@extends("layouts.admin")
@section("title", "Edit Posko")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('posko.index') }}">Posko</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-mailbox"></i>
                            </span>
                            Edit Data Posko
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="form" method="post" action="{{ route('posko.update', ['id' => $id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input hidden type="text" value="{{ $posko->id }}">
                                <div class="mb-2">
                                    <label class="form-label" for="nama">Nama Posko</label>
                                    <input id="nama" class="form-control" name="nama" type="text" value="{{ $posko->nama }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="jalan">Alamat (Jalan/gang)</label>
                                    <input id="jalan" class="form-control" name="jalan" type="text" value="{{ $posko->jalan }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="rw">Rukun Warga (RW)</label>
                                    <select class="form-select" id="rw" name="rw" required>
                                        @for ($i = 1; $i <= 10; $i++) @php $formattedValue=str_pad($i, 2, '0' , STR_PAD_LEFT); @endphp <option value="{{ $formattedValue }}" {{ $posko->rw == $formattedValue ? 'selected' : '' }}>RW {{ $formattedValue }}</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="rt">Rukun Tetangga (RT)</label>
                                    <select class="select2 form-control" id="rt" name="rt[]" multiple="multiple">
                                        @for ($i = 1; $i <= 10; $i++) @php $formattedValue=str_pad($i, 2, '0' , STR_PAD_LEFT); $isSelected='' ; foreach ($lingkup as $arr) { if ($arr->rt == $formattedValue) {
                                            $isSelected = 'selected';
                                            break; // Jika sudah ditemukan, hentikan perulangan
                                            }
                                            }
                                            @endphp
                                            <option value="{{ $formattedValue }}" {{ $isSelected }}>RW {{ $formattedValue }}</option>
                                            @endfor
                                    </select>
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
        $('.select2').select2();
    });
</script>
@endpush
@endsection
