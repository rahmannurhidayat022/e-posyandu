@extends("layouts.admin")
@section("title", "Tambah Artikel")
@section("content")
@push('head')
@endpush
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Artikel</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-file"></i>
                            </span>
                            Tambah Artikel
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="" method="post" action="{{ route('article.store') }}" enctype="multipart/form-data" accept-charset="utf-8" style="width: 100%; max-width: 700px">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label" for="title">Judul</label>
                                    <input id="title" class="form-control form-sm" name="title" type="text" value="{{ old('title') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="image">Cover</label>
                                    <input class="form-control" id="image" name="image" type="file" accept=".png,.jpg,.jpeg" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="content">Konten</label>
                                    <textarea class="form-control" name="content" id="content" style="min-height: 250px;"></textarea>
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
</script>
@endpush
@endsection
