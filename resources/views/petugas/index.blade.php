@extends("layouts.admin")
@section("title", "Petugas Kesehatan")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Manajemen Petugas Kesehatan</h2>
                    <div class="mt-4">
                        <table id="petugas-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Telepon</th>
                                    <th>Puskesmas</th>
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
                container: 'petugas-table',
                ajax: "{{ route('petugas.index') }}",
                createPageUrl: '/petugas/create',
                editPageUrl: '/petugas/{id}/edit',
                deleteActionUrl: '/petugas/{id}/{user_id}/destroy',
                isChild: false,
                isNumber: true,
                columns: [{
                        data: 'user.username',
                        name: 'user.username'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'telp',
                        name: 'telp',
                    },
                    {
                        data: 'puskesmas',
                        name: 'puskesmas',
                    },
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Petugas Kesehatan',
                title: 'Laporan Data Petugas Kesehatan',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Petugas Kesehatan',
                title: 'Laporan Data Petugas Kesehatan',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Petugas Kesehatan',
                title: 'Laporan Data Petugas Kesehatan',
            },
        })
    });
</script>
@endpush
@endsection
