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
                    @if ($limit)
                    <div class="alert alert-primary">Index massa anak sudah mencapai <strong>60 bulan (5 tahun)</strong></div>
                    @endif
                    <h2 class="card-title fw-semibold mb-4">Riwayat Penimbangan {{ $anak->nama }}</h2>
                    <div class="mt-4">
                        <table id="penimbangan-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>No.Layanan</th>
                                    <th>Usia</th>
                                    <th>BB</th>
                                    <th>BB Status</th>
                                    <th>TB</th>
                                    <th>TB Status</th>
                                    <th>Status Gizi</th>
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
                ageLimit: '{{ $limit }}',
                isChild: true,
                deleteActionUrl: '/kesehatan-anak/penimbangan/{id}/destroy',
                isNumber: true,
                kmsPageUrl: '{{ $is_kms }}' && '/kesehatan-anak/kms/{{ $id }}',
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
                        data: 'bb',
                        name: 'bb',
                        render: (data, type, row) => {
                            let style = {}
                            if (row.bb_status.toLowerCase() === 'normal') {
                                style = {
                                    textColor: 'text-success',
                                    badgeColor: 'text-bg-success'
                                }
                            } else if (row.bb_status.toLowerCase() === 'sangat kurang') {
                                style = {
                                    textColor: 'text-danger-dark',
                                    badgeColor: 'text-bg-danger-dark'
                                }
                            } else if (row.bb_status.toLowerCase() === 'kurang') {
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
                            return `<span class="${style.textColor}">${data}</span>`
                        }
                    },
                    {
                        name: 'bb_status',
                        data: 'bb_status',
                        render: (data, type, row) => {
                            let style = {}
                            if (row.bb_status.toLowerCase() === 'normal') {
                                style = {
                                    textColor: 'text-success',
                                    badgeColor: 'text-bg-success'
                                }
                            } else if (row.bb_status.toLowerCase() === 'sangat kurang') {
                                style = {
                                    textColor: 'text-danger-dark',
                                    badgeColor: 'text-bg-danger-dark'
                                }
                            } else if (row.bb_status.toLowerCase() === 'kurang') {
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
                            return `<span class="badge badge-sm rounded-pill ${style.badgeColor}">${data.toUpperCase()}</span>`;
                        }
                    },
                    {
                        data: 'tb',
                        name: 'tb',
                        render: (data, type, row) => {
                            let style = {};
                            if (row.tb_status.toLowerCase() === 'normal') {
                                style = {
                                    textColor: 'text-success',
                                    badgeColor: 'text-bg-success'
                                }
                            } else if (row.tb_status.toLowerCase() === 'sangat pendek') {
                                style = {
                                    textColor: 'text-danger-dark',
                                    badgeColor: 'text-bg-danger-dark'
                                }
                            } else if (row.tb_status.toLowerCase() === 'pendek') {
                                style = {
                                    textColor: 'text-danger',
                                    badgeColor: 'text-bg-danger'
                                }
                            } else {
                                style = {
                                    textColor: 'text-primary',
                                    badgeColor: 'text-bg-primary'
                                }
                            }
                            return `<span class="me-1 ${style.textColor}">${data}</span>`

                        }
                    },
                    {
                        data: 'tb_status',
                        name: 'tb_status',
                        render: (data, type, row) => {
                            let style = {};
                            if (row.tb_status.toLowerCase() === 'normal') {
                                style = {
                                    textColor: 'text-success',
                                    badgeColor: 'text-bg-success'
                                }
                            } else if (row.tb_status.toLowerCase() === 'sangat pendek') {
                                style = {
                                    textColor: 'text-danger-dark',
                                    badgeColor: 'text-bg-danger-dark'
                                }
                            } else if (row.tb_status.toLowerCase() === 'pendek') {
                                style = {
                                    textColor: 'text-danger',
                                    badgeColor: 'text-bg-danger'
                                }
                            } else {
                                style = {
                                    textColor: 'text-primary',
                                    badgeColor: 'text-bg-primary'
                                }
                            }
                            return `<span class="badge badge-sm rounded-pill ${style.badgeColor}">${data.toUpperCase()}</span>`;
                        }
                    },
                    {
                        name: 'gizi_status',
                        data: 'gizi_status',
                        render: (data, type, row) => {
                            let style = {};
                            if (row.gizi_status.toLowerCase() === 'gizi buruk') {
                                style = {
                                    badgeColor: 'gt--min-2'
                                }
                            } else if (row.gizi_status.toLowerCase() === 'gizi kurang') {
                                style = {
                                    badgeColor: 'gt--min-1'
                                }
                            } else if (row.gizi_status.toLowerCase() === 'gizi normal') {
                                style = {
                                    badgeColor: 'gt--min-0'
                                }
                            } else if (row.gizi_status.toLowerCase() === 'berisiko gizi lebih') {
                                style = {
                                    badgeColor: 'gt--plus-1'
                                }
                            } else if (row.gizi_status.toLowerCase() === 'gizi lebih') {
                                style = {
                                    badgeColor: 'gt--plus-2'
                                }
                            } else if (row.gizi_status.toLowerCase() === 'obesitas') {
                                style = {
                                    badgeColor: 'gt--plus-3'
                                }
                            } else {
                                // Default style jika status tidak sesuai
                                style = {
                                    badgeColor: 'bg-secondary'
                                }
                            }
                            return `<span class="badge badge-sm rounded-pill ${style.badgeColor}">${data.toUpperCase()}</span>`;
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
                columns: [1, 2, 3, 4, 5, 6, 7, 8],
                filename: `Laporan Data Penimbangan {{ $anak->nama }}`,
                title: `Laporan Data Penimbangan {{ $anak->nama }}`,
            },
            excelConfiguration: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8],
                filename: `Laporan Data Penimbangan {{ $anak->nama }}`,
                title: `Laporan Data Penimbangan {{ $anak->nama }}`,
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4, 5, 6, 7, 8],
                filename: `Laporan Data Penimbangan {{ $anak->nama }}`,
                title: `Laporan Data Penimbangan {{ $anak->nama }}`,
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
