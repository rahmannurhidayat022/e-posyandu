@extends("layouts.admin")
@section("title", "Posko")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Posko Pelayanan Posyandu</h2>
                    <a href="{{ route('posko.create') }}" class="btn btn-primary">
                        <i class="ti ti-pencil-plus"></i>
                        Tambah Data
                    </a>
                    <div class="mt-4">
                        <table id="posko-table" class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Nama Posko</td>
                                    <td>Jalan / Gang</td>
                                    <td>RW</td>
                                    <td>RT</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPosko" tabindex="-1" aria-labelledby="addPosko" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex gap-2 align-items-center">
                    <div class="badge-circle">
                        <i class="ti ti-mailbox"></i>
                    </div>
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Input Data Posko Baru
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('posko.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label" for="nama">Nama Posko</label>
                            <input id="nama" class="form-control" name="nama" type="text" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="jalan">Alamat (Jalan/gang)</label>
                            <input id="jalan" class="form-control" name="jalan" type="text" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="rw">Rukun Warga (RW)</label>
                            <select class="form-select" id="rw" name="rw" required>
                                <option value="01" selected>RW 01</option>
                                <option value="02">RW 02</option>
                                <option value="03">RW 03</option>
                                <option value="04">RW 04</option>
                                <option value="05">RW 06</option>
                                <option value="07">RW 07</option>
                                <option value="08">RW 08</option>
                                <option value="09">RW 09</option>
                                <option value="10">RW 10</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="rt">Rukun Tetangga (RT)</label>
                            <select class="select2" id="rt" name="rt[]" multiple="multiple">
                                <option value="01">RT 01</option>
                                <option value="02">RT 02</option>
                                <option value="03">RT 03</option>
                                <option value="04">RT 04</option>
                                <option value="05">RT 06</option>
                                <option value="07">RT 07</option>
                                <option value="08">RT 08</option>
                                <option value="09">RT 09</option>
                                <option value="10">RT 10</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@push('script')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5'
        });

        const table = $("#posko-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('posko.index') }}",
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                    width: '10px',
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jalan',
                    name: 'jalan',
                },
                {
                    data: 'rw',
                    name: 'rw',
                    render: (data, type, row) => {
                        return `<span class="badge rounded-pill text-bg-info">${data}</span>`;
                    }
                },
                {
                    data: 'rt',
                    name: 'rt',
                    sortable: false,
                    render: (data, type, row) => {
                        const temp = JSON.parse(data);
                        let elements = '';
                        temp.forEach(({
                            rt
                        }) => {
                            elements += `<span class="badge rounded-pill text-bg-secondary me-1">${rt}</span>`;
                        })
                        return elements;
                    }
                },
                {
                    data: null,
                    name: 'action',
                    sortable: false,
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => {
                        return `<a class="btn btn-sm btn-success" href="/posko/${row.id}/edit"><i class="ti ti-edit"></i></a>
<button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
`
                    }
                }
            ]
        })
    })
</script>
@endpush
@endsection
