@extends("layouts.admin")
@section("title", "Kader")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Manajemen Kader</h2>
                    <div class="mt-4">
                        <table id="kader-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Posko</th>
                                    <th>RW</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('script')
<script>
    $(document).ready(function() {
        const table = window.initialDataTable({
            tableConfiguration: {
                name: 'kader',
                container: 'kader-table',
                ajax: "{{ route('kader.index') }}",
                createPageUrl: '/kader/create',
                editPageUrl: '/kader/{id}/edit',
                deleteActionUrl: '/kader/{id}/destroy',
                isChild: true,
                isNumber: true,
                formatChildRow: function(d) {
                    return (
                        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                        '<tr>' +
                        '<td><i class="ti ti-mailbox fs-6 text-info"></i></td>' +
                        '<td>' +
                        `Posko ${d.posko.nama} ${d.posko.jalan} RW${d.posko.rw}` +
                        '</td>' +
                        '<td><i class="ti ti-home-link fs-6 text-info"></i></td>' +
                        '<td>' +
                        `${d.jalan} RT${d.rt} RW${d.rw}` +
                        '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '</tr>' +
                        '</table>'
                    );
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'posko.nama',
                        name: 'posko.nama',
                        render: (data, type, row) => {
                            return `<span class="badge badge-sm rounded-pill text-bg-info text-uppercase">${data}</span>`;
                        }
                    },
                    {
                        data: 'posko.rw',
                        name: 'posko.rw',
                        render: (data, type, row) => {
                            return `<span class="badge badge-sm rounded-pill text-bg-info">RW ${data}</span>`;
                        }
                    },
                    {
                        data: 'telp',
                        name: 'telp',
                    },
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4, 5, 6],
                filename: 'Laporan Data Kader',
                title: 'Laporan Data Kader',
            },
            excelConfiguration: {
                columns: [1, 2, 3, 4, 5, 6],
                filename: 'Laporan Data Kader',
                title: 'Laporan Data Kader',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4, 5, 6],
                filename: 'Laporan Data Kader',
                title: 'Laporan Data Kader',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
