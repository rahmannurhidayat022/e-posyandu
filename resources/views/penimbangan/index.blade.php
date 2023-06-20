@extends("layouts.admin")
@section("title", "Penimbangan Anak")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('anak.index') }}">Kesehatan Anak</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Penimbangan</li>
                        </ol>
                    </nav>
                    <h2 class="card-title fw-semibold mb-4">Riwayat Penimbangan {{ $anak->nama }}</h2>
                    <div class="mt-4">
                        <table id="penimbangan-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>No.Layanan</th>
                                    <th>Usia</th>
                                    <th>Berat Badan</th>
                                    <th>Tinggi Badan</th>
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
                name: 'Penimbangan Anak',
                container: 'penimbangan-table',
                ajax: "{{ route('penimbangan.index', $id) }}",
                createPageUrl: '/kesehatan-anak/penimbangan/{{ $id }}/create',
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
                            <td>Petugas Kader:</td>
                            <td>${d.kader.nama}</td>
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
                        data: 'bb',
                        name: 'bb',
                        render: (data, type, row) => {
                            let style = {}
                            if (row.bb_status === 'normal') {
                                style = {
                                    textColor: 'text-success',
                                    badgeColor: 'text-bg-success'
                                }
                            } else if (row.bb_status === 'kurang') {
                                style = {
                                    textColor: 'text-danger',
                                    badgeColor: 'text-bg-danger'
                                }
                            } else {
                                style = {
                                    textColor: 'text-warning',
                                    badgeColor: 'text-bg-warning'
                                }
                            }
                            return `<span class="me-1 ${style.textColor}">${data}</span><span class="badge badge-sm rounded-pill ${style.badgeColor}">${row.bb_status.toUpperCase()}</span>`
                        }
                    },
                    {
                        data: 'tb',
                        name: 'tb',
                        render: (data, type, row) => {
                            let style = {};
                            if (row.tb_status === 'normal' || row.tb_status === 'tinggi') {
                                style = {
                                    textColor: 'text-success',
                                    badgeColor: 'text-bg-success'
                                }
                            } else {
                                style = {
                                    textColor: 'text-danger',
                                    badgeColor: 'text-bg-danger'
                                }
                            }
                            return `<span class="me-1 ${style.textColor}">${data}</span><span class="badge badge-sm rounded-pill ${style.badgeColor}">${row.tb_status.toUpperCase()}</span>`

                        }
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
