@extends("layouts.admin")
@section("title", "Data Ibu")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Manajemen Data Ibu</h2>
                    <div class="mt-4">
                        <table id="ibu-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Ibu</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Ayah</th>
                                    <th>NIK</th>
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
                name: 'ibu',
                container: 'ibu-table',
                ajax: "{{ route('ibu.index') }}",
                createPageUrl: '/ibu/create',
                editPageUrl: '/ibu/{id}/edit',
                isChild: true,
                deleteActionUrl: '/ibu/{id}/destroy',
                isNumber: true,
                formatChildRow: function(d) {
                    return (
                        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                        '<tr>' +
                        '<td>' +
                        `<i class="ti ti-mailbox fs-6 text-info"></i> Posko ${d.posko.nama}, ${d.posko.jalan} RW${d.posko.rw}` +
                        '</td>' +
                        '<td></td>' +
                        '<td>' +
                        `<i class="ti ti-home-link fs-6 text-info"></i> ${d.jalan} RT${d.rt} RW${d.rw}` +
                        '</td>' +
                        '<td class="d-flex align-items-center">' +
                        `<i class="ti ti-droplet-filled fs-6 text-info"></i> Gol. Darah ${d.darah}` +
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
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir',
                    },
                    {
                        data: 'ayah',
                        name: 'ayah',
                    },
                    {
                        data: 'nik',
                        name: 'nik',
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
                filename: 'Laporan Data Ibu',
                title: 'Laporan Data Ibu',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Ibu',
                title: 'Laporan Data Ibu',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Ibu',
                title: 'Laporan Data Ibu',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
