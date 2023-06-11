@extends("layouts.admin")
@section("title", "Posko")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Posko Pelayanan Posyandu</h2>
                    <div class="mt-4">
                        <table id="posko-table" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Posko</td>
                                    <td>Jalan / Gang</td>
                                    <td>RW</td>
                                    <td>RT</td>
                                    <td>Aksi</td>
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
                name: 'posko',
                container: 'posko-table',
                ajax: "{{ route('posko.index') }}",
                createPageUrl: '/posko/create',
                editPageUrl: '/posko/{id}/edit',
                deleteActionUrl: '/posko/{id}/destroy',
                columns: [{
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
                            return `<span class="badge badge-sm rounded-pill text-bg-info">${data}</span>`;
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
                                elements += `<span class="badge badge-sm rounded-pill text-bg-info me-1">${rt}</span>`;
                            })
                            return elements;
                        }
                    },
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Posko',
                title: 'Laporan Data Posko',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Posko',
                title: 'Laporan Data Posko',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Posko',
                title: 'Laporan Data Posko',
                isRt: true,
            },
        })
    })
</script>
@endpush
@endsection
