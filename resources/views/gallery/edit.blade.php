@extends("layouts.admin")
@section("title", "Edit Galeri")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-photo-plus"></i>
                            </span>
                            Edit Galeri
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('gallery.update', $id) }}" enctype="multipart/form-data" accept-charset="utf-8" style="width: 100%; max-width: 450px">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="border rounded-circle overflow-hidden mb-4 mx-auto" style="width: 150px; height: 150px;">
                                    <img src="{{ asset('storage/gallery/'.$data->image) }}" alt="{{ $data->caption }}" style="width: 100%; height: 100%; object-fit: cover; object-position: center">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="caption">Caption</label>
                                    <input id="caption" class="form-control form-sm" name="caption" type="text" value="{{ $data->caption }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="images">Foto Baru</label>
                                    <input class="form-control" id="images" name="image" type="file" accept=".png,.jpg,.jpeg">
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
