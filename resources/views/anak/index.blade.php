@extends("layouts.admin")
@section("title", "Data Anak")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Penimbangan Anak</h2>
                    <div class="mt-4">
                        <table id="anak-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Ibu</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
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
                name: 'ibu',
                container: 'anak-table',
                ajax: "{{ route('anak.index') }}",
                createPageUrl: '/kesehatan-anak/create',
                editPageUrl: '/kesehatan-anak/{id}/edit',
                isChild: true,
                deleteActionUrl: '/kesehatan-anak/{id}/destroy',
                isNumber: true,
                isImunisasi: true,
                filters: {
                    posko_id: "{{ session('user_information')->posko->id ?? null }}"
                },
                isPenimbanganAction: true,
                formatChildRow: function(d) {
                    return (
                        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                        `<tr>
                            <td>NIK:</td>
                            <td>${d.nik}</td>
                        </tr>` +
                        `<tr>
                            <td>Dibuat:</td>
                            <td>${d.created_at}</td>
                            <td>Diperbaharui:</td>
                            <td>${d.updated_at}</td>
                        </tr>` +
                        '</table>'
                    );
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'ibu.nama',
                        name: 'ibu.nama',
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir',
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        render: (data, type, row) => {
                            return `<span class="bagde bg-text-primary">${data === 'lk' ? 'Laki-laki' : 'Perempuan'}</span>`
                        }
                    },
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Anak',
                title: 'Laporan Data Anak',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Anak',
                title: 'Laporan Data Anak',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Anak',
                title: 'Laporan Data Anak',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
