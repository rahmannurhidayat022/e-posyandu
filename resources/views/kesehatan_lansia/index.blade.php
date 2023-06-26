@extends("layouts.admin")
@section("title", "Cek Kesehatan Lansia")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('lansia.index') }}">Lansia</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cek Kesehatan</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">Riwayat Penimbangan {{ $lansia->nama }}</h2>
                    <div class="mt-4">
                        <table id="kesehatan-lansia-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>No.Layanan</th>
                                    <th>Berat Badan</th>
                                    <th>Tinggi Badan</th>
                                    <th>Tekanan Darah</th>
                                    <th>Kolestrol</th>
                                    <th>Gula Darah</th>
                                    <th>Tanggal</th>
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
                name: 'kesehatan-lansia',
                container: 'kesehatan-lansia-table',
                ajax: "{{ route('kesehatan_lansia.index', $id) }}",
                createPageUrl: '/lansia/cek-kesehatan/{{ $id }}/create',
                editPageUrl: '/kesehatan-anak/penimbangan/{anak_id}/{id}/edit',
                isChild: true,
                deleteActionUrl: '/kesehatan-anak/penimbangan/{id}/destroy',
                isNumber: true,
                formatChildRow: function(d) {
                    return (
                        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                        `<tr>
                            <td>Posko:</td>
                            <td>${d.posko.nama} ${d.posko.rw}</td>
                        </tr>` +
                        `<tr>
                            <td>Petugas Kesehatan:</td>
                            <td>${d.petugas.nama}</td>
                        </tr>` +
                        `<tr>
                            <td>Keluhan:</td>
                            <td>${d.keluhan ? d.keluhan : '-'}</td>
                        </tr>` +
                        `<tr>
                            <td>Catatan:</td>
                            <td>${d.catatan ? d.catatan : '-'}</td>
                        </tr>` +
                        '</table>'
                    );
                },
                columns: [{
                        data: 'id_layanan',
                        name: 'id_layanan'
                    },
                    {
                        data: 'bb',
                        name: 'bb',
                        render: (data, type, row) => (`${data} Kg`)
                    },
                    {
                        data: 'tb',
                        name: 'tb',
                        render: (data, type, row) => (`${data} Cm`)
                    },
                    {
                        data: 'tekanan_darah',
                        name: 'tekanan_darah',
                        render: (data, type, row) => (`${data} mmHg`)
                    },
                    {
                        data: 'kolestrol',
                        name: 'kolestrol',
                        render: (data, type, row) => (`${data} mg/dL`)
                    },
                    {
                        data: 'gula_darah',
                        name: 'gula_darah',
                        render: (data, type, row) => (`${data} mg/dL`)
                    },
                    {
                        name: 'created_at',
                        data: 'created_at',
                    }
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Penimbangan Anak',
                title: 'Laporan Data Penimbangan Anak',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Penimbangan Anak',
                title: 'Laporan Data Penimbangan Anak',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Penimbangan Anak',
                title: 'Laporan Data Penimbangan Anak',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
