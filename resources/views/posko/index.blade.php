@extends("layouts.admin")
@section("title", "Posko")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Posko Pelayanan Posyandu</h2>
                    <div class="mt-4">
                        <table id="posko-table" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Posko</td>
                                    <td>Jalan / Gang</td>
                                    <td>RW</td>
                                    <td>RT</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-confirmation">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteConfirmationModalLabel">Kofirmasi Hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@push('script')
<script>
    function confirmAlert(event) {
        var id = event.getAttribute('data-id');
        var form = $('#deleteForm');
        var actionUrl = `/posko/${id}/destroy`;
        form.attr('action', actionUrl);
    }

    $(document).ready(function() {

        $('.select2').select2({
            theme: 'bootstrap-5'
        });

        const exportFormat = {
            exportOptions: {
                format: {
                    body: function(data, row, column, node) {
                        return column === 4 ?
                            data.replace(/(\d{2})(?=\d)/g, '$1/') :
                            data;
                    }
                }
            }
        };

        const getCurrentDate = () => {
            const currentDate = new Date();

            const day = String(currentDate.getDate()).padStart(2, '0');
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const year = currentDate.getFullYear();

            return day + '-' + month + '-' + year;
        }

        const table = $("#posko-table").DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    text: '<i class="ti ti-pencil-plus fs-4"></i>',
                    className: 'btn btn-primary',
                    attr: {
                        'title': 'Tambah Data'
                    },
                    action: function(e, dt, node, config) {
                        window.location = '/posko/create';
                    }
                },
                {
                    text: '<i class="ti ti-printer fs-4"></i>',
                    className: 'btn btn-secondary',
                    attr: {
                        'title': 'Print Data'
                    },
                    extend: 'print',
                    orientation: 'potrait',
                    pageSize: 'A4',
                    exportOptions: {
                        stripHtml: true,
                        columns: [0, 1, 2, 3, 4],
                    },
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '10pt')
                            .prepend(
                                '<img width="350" src="https://1.bp.blogspot.com/-7q_IogOnUHo/YNHgD0ioCSI/AAAAAAAAInM/MXO6tYZM5J0PGzV7a9Wa6oJMaRRuxHD6gCLcBGAsYHQ/s1300/logo-posyandu.png" style="position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.3;" />'
                            );

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
                {
                    text: '<i class="ti ti-file-spreadsheet fs-4"></i>',
                    className: 'btn btn-secondary',
                    extend: 'excelHtml5',
                    attr: {
                        'title': 'Export Excel'
                    },
                    autoFilter: true,
                    filename: `Laporan Data Posko ${getCurrentDate()}`,
                    title: `Laporan Data Posko ${getCurrentDate()}`,
                    exportOptions: {
                        stripHtml: true,
                        columns: [0, 1, 2, 3, 4],
                    }
                },
                {
                    text: '<i class="ti ti-file-lambda fs-4"></i>',
                    className: 'btn btn-secondary',
                    extend: 'pdfHtml5',
                    attr: {
                        'title': 'Export PDF'
                    },
                    download: 'open',
                    orientation: 'potrait',
                    pageSize: 'A4',
                    exportOptions: {
                        stripHtml: true,
                        columns: [1, 2, 3, 4],
                        modifier: 'formatted',
                        orthogonal: 'display',
                        format: {
                            body: function(data, row, column, node) {
                                var stripedData = data.toString().replace(/<[^>]+>/g, '');
                                if (column === 3) {
                                    stripedData = stripedData.replace(/(\d{2})(?=\d)/g, '$1/');
                                }
                                return stripedData;
                            }
                        },
                    },
                    customize: function(doc) {
                        doc.defaultStyle.tableWidth = 'auto';
                        doc.styles.tableHeader.alignment = 'left';
                        doc.content[0].text = '';
                        doc.content[1].table.widths = Array(doc.content[1].table.body[2].length + 1).join('*').split('');
                    }
                }
            ],
            processing: true,
            serverSide: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            ajax: "{{ route('posko.index') }}",
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                    width: '10px',
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jalan',
                    name: 'jalan',
                },
                {
                    data: 'rw',
                    name: 'rw',
                    render: (data, type, row) => {
                        return `<span class="badge rounded-pill text-bg-info">${data}</span>`;
                    }
                },
                {
                    data: 'rt',
                    name: 'rt',
                    sortable: false,
                    render: (data, type, row) => {
                        const temp = JSON.parse(data);
                        let elements = temp.length ? '' : '-';
                        temp.forEach(({
                            rt
                        }) => {
                            elements += `<span class="badge rounded-pill text-bg-info me-1">${rt}</span>`;
                        })
                        return elements;
                    }
                },
                {
                    data: null,
                    name: 'action',
                    sortable: false,
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => {
                        return `<a class="btn btn-sm btn-success" title="Edit Data" href="/posko/${row.id}/edit"><i class="ti ti-edit"></i></a>
<button type="button" title="Hapus Data" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" class="btn btn-sm btn-danger" data-id="${row.id}" onclick="confirmAlert(this)"><i class="ti ti-trash"></i></button>
`
                    }
                }
            ],
            columnDefs: [{
                defaultContent: "-",
                targets: "_all"
            }, ],
        })

        table.on('draw.dt', function() {
            $('.dt-buttons').addClass('btn-group');
        });
    })
</script>
@endpush
@endsection
