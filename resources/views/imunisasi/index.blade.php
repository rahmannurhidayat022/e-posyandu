@extends("layouts.admin")
@section("title", "Imunisasi Anak")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('anak.index') }}">Kesehatan Anak</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Imunisasi</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">Riwayat Imunisasi {{ $anak->nama }}</h2>
                    <div class="mt-4">
                        <table id="imunisasi-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>No.Layanan</th>
                                    <th>Usia</th>
                                    <th>Jenis Vaksin</th>
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
                name: 'Imunisasi Anak',
                container: 'imunisasi-table',
                ajax: "{{ route('imunisasi.index', $id) }}",
                createPageUrl: '/kesehatan-anak/imunisasi/{{ $id }}/create',
                editPageUrl: '/kesehatan-anak/imunisasi/{anak_id}/{id}/edit',
                ageLimit: '{{ $limit }}',
                isChild: true,
                deleteActionUrl: '/kesehatan-anak/imunisasi/{id}/destroy',
                isNumber: true,
                // kmsPageUrl: '{{ $is_kms }}' && '/kesehatan-anak/kms/{{ $id }}',
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
                        data: 'usia',
                        name: 'usia',
                    },
                    {
                        data: 'jenis_vaksin',
                        name: 'jenis_vaksin',
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
                filename: 'Laporan Data Imunisasi Anak',
                title: 'Laporan Data Imunisasi Anak',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Imunisasi Anak',
                title: 'Laporan Data Imunisasi Anak',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Imunisasi Anak',
                title: 'Laporan Data Imunisasi Anak',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
