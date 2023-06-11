<!doctype html>
<html lang="en">

<head>
    <title>@yield("title") E-Posyandu Kebon Jayanti</title>
    @include("includes.head")
</head>

<body>
    @include('sweetalert::alert')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/posyandu_full.png') }}" width="180" alt="logo posyandu" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
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
                            <span class="hide-menu">MANAJEMEN AKUN</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="hide-menu">Admin</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('kader.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-users">Kader</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('petugas.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-first-aid-kit"></i>
                                </span>
                                <span class="hide-menu">Petugas</span>
                            </a>
                        </li>
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
                                @if(Auth::user()->user_information)
                                {{ Auth::user()->user_information->nama }}
                                @else
                                Admin
                                @endif
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
                    dom: '<"btn-group w-100 mb-3" B>lfrtip',
                    buttons: [{
                            text: '<i class="ti ti-pencil-plus fs-4"></i>',
                            className: 'btn btn-primary',
                            attr: {
                                'title': 'Tambah Data'
                            },
                            action: function() {
                                window.location = tableConfiguration.createPageUrl;
                            }
                        },
                        {
                            text: '<i class="ti ti-printer fs-4"></i>',
                            className: 'btn btn-secondary',
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
                            className: 'btn btn-secondary',
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
                            className: 'btn btn-secondary',
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
                                doc.content[0].text = '';
                                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            }
                        }
                    ],
                    processing: true,
                    serverSide: true,
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    ajax: tableConfiguration.ajax,
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                            orderable: false,
                            searchable: false,
                            width: '10px',
                        },
                        ...tableConfiguration.columns,
                        {
                            data: null,
                            name: 'action',
                            sortable: false,
                            orderable: false,
                            searchable: false,
                            render: (data, type, row) => {
                                const editUrl = replaceStringWithObjectValues(tableConfiguration.editPageUrl, row);
                                const deleteUrl = replaceStringWithObjectValues(tableConfiguration.deleteActionUrl, row);

                                return `<a class="btn btn-success" title="Edit Data" href="${editUrl}"><i class="ti ti-edit"></i></a>
<button type="button" title="Hapus Data" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" class="btn btn-danger" onclick="confirmAlert({ formId: 'form-delete', deleteUrl: '${deleteUrl}' })"><i class="ti ti-trash"></i></button>
`
                            }
                        }
                    ],
                    columnDefs: [{
                        defaultContent: "-",
                        targets: "_all"
                    }, ],
                })

                return table;
            }
        });
    </script>
    @stack("script")
</body>

</html>
