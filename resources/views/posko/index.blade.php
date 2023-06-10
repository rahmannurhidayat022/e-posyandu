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
                        <table id="posko-table" class="display nowrap" style="width:100%">
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
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-confirmation">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteConfirmationModalLabel">Kofirmasi Hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@push('script')
<script>
    function confirmAlert(event) {
        var id = event.getAttribute('data-id');
        var form = $('#deleteForm');
        var actionUrl = `/posko/${id}/destroy`;
        form.attr('action', actionUrl);
    }

    $(document).ready(function() {

        $('.select2').select2({
            theme: 'bootstrap-5'
        });

        const table = $("#posko-table").DataTable({
            processing: true,
            serverSide: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
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
                        let elements = temp.length ? '' : '-';
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
<button type="button" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" class="btn btn-sm btn-danger" data-id="${row.id}" onclick="confirmAlert(this)"><i class="ti ti-trash"></i></button>
`
                    }
                }
            ],
            columnDefs: [{
                defaultContent: "-",
                targets: "_all"
            }, ],
        })
    })
</script>
@endpush
@endsection
