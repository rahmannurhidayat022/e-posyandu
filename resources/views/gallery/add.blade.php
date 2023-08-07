@extends("layouts.admin")
@section("title", "Tambah Galeri")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-photo-plus"></i>
                            </span>
                            Tambah Galeri
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('gallery.store') }}" enctype="multipart/form-data" accept-charset="utf-8" style="width: 100%; max-width: 450px">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label" for="caption">Caption</label>
                                    <input id="caption" class="form-control form-sm" name="caption" type="text" value="{{ old('caption') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="images">Foto</label>
                                    <input class="form-control" id="images" name="images[]" type="file" accept=".png,.jpg,.jpeg" multiple required>
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
