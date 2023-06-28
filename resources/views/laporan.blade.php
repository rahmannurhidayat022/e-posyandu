@extends("layouts.admin")
@section("title", "data lansia")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Laporan Pelayanan Posyandu</h2>
                    <div class="mt-4">
                        <table id="laporan-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>no</th>
                                    <th>Tanggal</th>
                                    <th>Layanan</th>
                                    <th></th>
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
                name: 'laporan',
                container: 'laporan-table',
                ajax: "{{ route('laporan.index') }}",
                createPageUrl: '/lansia/create',
                editPageUrl: '/lansia/{id}/edit',
                isChild: false,
                deleteActionUrl: '/lansia/{id}/destroy',
                isNumber: false,
                isKesehatanLansia: true,
                isAksi: false,
                columns: [{
                        data: 'tanggal',
                        name: 'tanggal',
                    },
                    {
                        data: 'laporan',
                        name: 'laporan',
                        sortable: false,
                        searchable: false,
                    },
                    {
                        data: null,
                        name: 'export',
                        searchable: false,
                        sortable: false,
                        orderable: false,
                    }
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Lansia',
                title: 'Laporan Data Lansia',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Lansia',
                title: 'Laporan Data Lansia',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Lansia',
                title: 'Laporan Data Lansia',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
