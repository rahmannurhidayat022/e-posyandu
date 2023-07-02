@extends("layouts.admin")
@section("title", "Data Lansia")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Kesehatan Lansia</h2>
                    <div class="mt-4">
                        <table id="lansia-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Tanggal Lahir</th>
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
                name: 'lansia',
                container: 'lansia-table',
                ajax: "{{ route('lansia.index') }}",
                createPageUrl: '/lansia/create',
                editPageUrl: '/lansia/{id}/edit',
                isChild: true,
                deleteActionUrl: '/lansia/{id}/destroy',
                isNumber: true,
                filters: {
                    posko_id: "{{ session('user_information')->posko->id ?? null }}"
                },
                isKesehatanLansia: true,
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
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir',
                    },
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Lansia',
                title: 'Laporan Data Lansia',
            },
            excelConfiguration: {
                columns: [1, 2, 3, 4],
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
