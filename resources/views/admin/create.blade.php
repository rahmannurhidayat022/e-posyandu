@extends("layouts.admin")
@section("title", "Create Admin Account")
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Akun</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">
                        <div class="d-flex gap-2">
                            <span class="badge-circle">
                                <i class="ti ti-user"></i>
                            </span>
                            Tambah Akun Admin
                        </div>
                    </h2>
                    <div class="mt-4">
                        <form class="form" method="post" action="{{ route('admin.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label class="form-label" for="role">Role</label>
                                    <select id="role" name="role" class="form-select" required>
                                        <option value="operator" selected>Operator</option>
                                        <option value="admin">Admin</option>
                                        <option value="viewer">Viewer</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="posko_id">Posko</label>
                                    <select id="list-posko" class="select2 form-select" id="posko_id" name="posko_id" required>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="nama">Nama</label>
                                    <input id="nama" class="form-control" name="nama" type="text" value="{{ old('nama') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="username">Username</label>
                                    <input id="username" class="form-control" name="username" type="text" value="{{ old('username') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="password">Password</label>
                                    <input id="password" class="form-control" name="password" type="password" min="6" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                    <input id="password_confirmation" class="form-control" name="password_confirmation" type="password" required>
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
        })
    });
</script>
@endpush
@endsection
