<!doctype html>
<html lang="en">

<head>
    <title>@yield("title") E-Posyandu Kebon Jayanti</title>
    @include("includes.head")
    @stack('head')
</head>

<body>
    @include('sweetalert::alert')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-center">
                    <a href="{{ route('dashboard.index') }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/posyandu_full.png') }}" width="130" alt="logo posyandu" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="" style="overflow-y: auto;">
                    <ul id="sidebarnav" class="pb-5">
                        <li class="nav-small-cap m-0 p-0 d-flex justify-content-center">
                            <span class="badge badge-sm rounded-pill text-bg-info">
                                {!! Auth::user()->role !!}
                            </span>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('dashboard.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        @if (Auth::user()->role === "admin")
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('gallery.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-photo"></i>
                                </span>
                                <span class="hide-menu">Galeri</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('article.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file"></i>
                                </span>
                                <span class="hide-menu">Artikel</span>
                            </a>
                        </li>
                        @endif
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Pelayanan Posyandu</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('anak.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-activity"></i>
                                </span>
                                <span class="hide-menu">Kesehatan Anak</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('lansia.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-activity"></i>
                                </span>
                                <span class="hide-users">Kesehatan Lansia</span>
                            </a>
                        </li>
                        @if (Auth::user()->role === "admin" || Auth::user()->role === "viewer")
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('laporan.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-analytics"></i>
                                </span>
                                <span class="hide-menu">Laporan Pelayanan</span>
                            </a>
                        </li>
                        @endif
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Tempat Pelayanan</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('posko.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-mailbox"></i>
                                </span>
                                <span class="hide-menu">Posko</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">DATA MASTER</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('vaksin.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-vaccine"></i>
                                </span>
                                <span class="hide-users">Vaksin</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('ibu.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-empathize"></i>
                                </span>
                                <span class="hide-users">Ibu</span>
                            </a>
                        </li>
                        <!-- <li class="sidebar-item"> -->
                        <!--     <a class="sidebar-link" href="{{ route('kader.index') }}" aria-expanded="false"> -->
                        <!--         <span> -->
                        <!--             <i class="ti ti-heart-handshake"></i> -->
                        <!--         </span> -->
                        <!--         <span class="hide-users">Kader</span> -->
                        <!--     </a> -->
                        <!-- </li> -->
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('petugas.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-first-aid-kit"></i>
                                </span>
                                <span class="hide-menu">Petugas</span>
                            </a>
                        </li>
                        @if (Auth::user()->role === "admin")
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="hide-menu">Kader & Pengguna</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown d-flex align-items-center">
                                <span class="fw-bold">@if(Auth::user()->nama)
                                    {{ Auth::user()->nama }}
                                    @else
                                    {{ Auth::user()->username }}
                                    @endif</span>
                                <a class="nav-link nav-icon-hover p-1" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-user-circle fs-8" style="font-size: 18px;"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <form class="d-flex" method="post" action="{{ route('auth.logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-1">
                                                Keluar
                                                <i class="ti ti-logout fs-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">
                @yield("content")
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">© 2023 - <strong>E-Posyandu Kebon Jayanti</strong>
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
                        <form id="form-delete" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("includes.script")
    <script>
        $(document).ready(function() {
            $('.tooltip').tooltipster();
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            window.initialDataTable = ({
                tableConfiguration,
                printConfiguration,
                excelConfiguration,
                pdfConfiguration
            }) => {
                const table = $(`#${tableConfiguration.container}`).DataTable({
                    dom: tableConfiguration.hiddenTools ? '' : '<"w-100 mb-3" B>lfrtip',
                    buttons: [{
                            text: '<i class="ti ti-pencil-plus fs-4"></i>',
                            className: function() {
                                let disabled = '';
                                if (tableConfiguration?.ageLimit) {
                                    disabled = 'disabled';
                                }
                                if ("{{ Auth::user()->role }}" === "viewer") disabled = 'disabled'

                                return `btn btn-primary ${disabled}`
                            },
                            attr: {
                                'title': 'Tambah Data'
                            },
                            action: function() {
                                window.location = tableConfiguration.createPageUrl;
                            }
                        },
                        {
                            text: '<i class="ti ti-chart-dots fs-4"></i>',
                            className: `${tableConfiguration?.kmsPageUrl ? '' : 'd-none'} btn btn-primary`,
                            attr: {
                                'title': 'Kartu Menuju Sehat (KMS)'
                            },
                            action: function() {
                                window.location = tableConfiguration.kmsPageUrl;
                            }
                        },
                        {
                            text: '<i class="ti ti-printer fs-4"></i>',
                            className: `btn btn-secondary ${tableConfiguration.hiddenExportButton ? 'd-none' : ''}`,
                            attr: {
                                'title': 'Print Data'
                            },
                            extend: 'print',
                            orientation: printConfiguration.orientation,
                            pageSize: printConfiguration.pageSize,
                            filename: `${excelConfiguration.filename} ${getCurrentDate()}`,
                            title: `${excelConfiguration.title} ${getCurrentDate()}`,
                            exportOptions: {
                                stripHtml: true,
                                columns: printConfiguration.columns,
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
                            className: `btn btn-secondary ${tableConfiguration.hiddenExportButton ? 'd-none' : ''}`,
                            extend: 'excelHtml5',
                            attr: {
                                'title': 'Export Excel'
                            },
                            autoFilter: true,
                            filename: `${excelConfiguration.filename} ${getCurrentDate()}`,
                            title: `${excelConfiguration.title} ${getCurrentDate()}`,
                            exportOptions: {
                                stripHtml: true,
                                columns: excelConfiguration.columns,
                            }
                        },
                        {
                            text: '<i class="ti ti-file-lambda fs-4"></i>',
                            className: `btn btn-secondary ${tableConfiguration.hiddenExportButton ? 'd-none' : ''}`,
                            extend: 'pdfHtml5',
                            attr: {
                                'title': 'Export PDF'
                            },
                            download: 'open',
                            orientation: pdfConfiguration.orientation,
                            pageSize: pdfConfiguration.pageSize,
                            filename: `${excelConfiguration.filename} ${getCurrentDate()}`,
                            exportOptions: {
                                stripHtml: true,
                                columns: pdfConfiguration.columns,
                                modifier: 'formatted',
                                orthogonal: 'display',
                                format: {
                                    body: function(data, row, column, node) {
                                        var stripedData = data.toString().replace(/<[^>]+>/g, '');
                                        if (tableConfiguration.name === "posko" && column === 3) {
                                            stripedData = stripedData.replace(/(\d{2})(?=\d)/g, '$1/');
                                        }
                                        return stripedData;
                                    }
                                },
                            },
                            customize: function(doc) {
                                doc.defaultStyle.tableWidth = 'auto';
                                doc.styles.tableHeader.alignment = 'left';
                                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            }
                        },
                    ],
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: tableConfiguration.ajax,
                        data: function(d) {
                            if (tableConfiguration?.filters?.posko_id) {
                                d.posko_id = tableConfiguration?.filters?.posko_id;
                            }
                            d.search = $(`input[type="search"][aria-controls="${tableConfiguration.container}"]`).val();
                        }
                    },
                    columns: [{
                            data: null,
                            defaultContent: '',
                            orderable: false,
                            sortable: false,
                            searchable: false,
                            visible: tableConfiguration.isChild,
                        },
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                            orderable: false,
                            searchable: false,
                            sortable: false,
                            width: '10px',
                            visible: tableConfiguration.isNumber,
                        },
                        ...tableConfiguration.columns,
                        {
                            data: null,
                            name: 'action',
                            sortable: false,
                            orderable: false,
                            searchable: false,
                            visible: tableConfiguration.isAksi,
                            render: (data, type, row) => {
                                let html = '';
                                if (tableConfiguration?.isPenimbanganAction) {
                                    html += `<li><a class="dropdown-item" href="/kesehatan-anak/penimbangan/${row.id}"><i class="ti ti-scale"></i> Penimbangan</a></li>`
                                }
                                if (tableConfiguration?.isKesehatanLansia) {
                                    html += `<li><a class="dropdown-item" href="/lansia/cek-kesehatan/${row.id}"><i class="ti ti-heartbeat"></i> Cek Kesehatan</a></li>`
                                }
                                if (tableConfiguration.isImunisasi) {
                                    html += `<li><a class="dropdown-item" href="/kesehatan-anak/imunisasi/${row.id}"><i class="ti ti-vaccine"></i> Imunisasi</a></li>`
                                }


                                const deleteUrl = replaceStringWithObjectValues(tableConfiguration.deleteActionUrl, row);

                                if (tableConfiguration?.editPageUrl) {
                                    const editUrl = replaceStringWithObjectValues(tableConfiguration.editPageUrl, row);
                                    html += `
<li><a class="dropdown-item ${"{{ Auth::user()->role }}" === "viewer" ? 'disabled' : ''}" href="${editUrl}"><i class="ti ti-edit"></i> Edit</a></li>
`
                                }
                                html += `
                                        <li><button type="button" class="dropdown-item ${"{{ Auth::user()->role }}" === "viewer" ? 'disabled' : ''}" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" onclick="confirmAlert({ formId: 'form-delete', deleteUrl: '${deleteUrl}' })"><i class="ti ti-trash"></i> Delete</button></li>
                                        `


                                return `<div class="dropdown">
                                  <i class="ti ti-dots-vertical fs-6" id="optionsDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer">
                                  </i>
                                  <ul class="dropdown-menu" aria-labelledby="optionsDropdown">
                                    ${html}
                                  </ul>
                                </div>`;
                            }
                        }
                    ],
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    columnDefs: [{
                            defaultContent: "-",
                            targets: "_all"
                        },
                        {
                            targets: 0,
                            className: 'dt-control',
                            orderable: false,
                            searchable: false,
                            sortable: false,
                            data: null,
                            defaultContent: '',
                        },
                    ],
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.11.4/i18n/id.json"
                    },
                    initComplete: function() {
                        // $(`#${tableConfiguration.container} thead tr td`).removeClass('dt-control');
                    }
                });

                if (tableConfiguration.isChild) {
                    $(`#${tableConfiguration.container} tbody`).on('click', 'td.dt-control', function() {
                        const tr = $(this).closest('tr');
                        const row = table.row(tr);

                        if (row.child.isShown()) {
                            row.child.hide();
                            tr.removeClass('shown');
                        } else {
                            row.child(tableConfiguration.formatChildRow(row.data())).show();
                            tr.addClass('shown');
                        }
                    });
                }

                return table;
            }
        });
    </script>
    @stack("script")
</body>

</html>
