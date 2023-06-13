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
                        <table id="kader-table" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama</td>
                                    <td>NIK</td>
                                    <td>Posko</td>
                                    <td>Telepon</td>
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
                name: 'kader',
                container: 'kader-table',
                ajax: "{{ route('kader.index') }}",
                createPageUrl: '/kader/create',
                editPageUrl: '/kader/{id}/edit',
                deleteActionUrl: '/kader/{id}/destroy',
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
                        name: 'posko',
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
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Kader',
                title: 'Laporan Data Kader',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Kader',
                title: 'Laporan Data Kader',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Kader',
                title: 'Laporan Data Kader',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
