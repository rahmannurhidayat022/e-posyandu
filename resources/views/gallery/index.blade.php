@extends("layouts.admin")
@section("title", "Data Gallery")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Galeri Posyandu</h2>
                    <div class="mt-4">
                        <table id="gallery-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Foto</th>
                                    <th>Caption</th>
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
                name: 'gallery',
                container: 'gallery-table',
                ajax: "{{ route('gallery.index') }}",
                createPageUrl: '/gallery/create',
                editPageUrl: '/gallery/{id}/edit',
                deleteActionUrl: '/gallery/{id}/destroy',
                hiddenExportButton: true,
                isNumber: false,
                isChild: false,
                columns: [{
                        data: 'image',
                        name: 'image',
                        render: (data, type, row) => {
                            return `<a href="/storage/gallery/${data}" target="_blank" class="d-flex align-items-center gap-1">
                                    ${data}
                                    <i class="ti ti-external-link"></i>
                                </a>
                                `
                        }
                    },
                    {
                        data: 'caption',
                        name: 'caption',
                    },
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4, 5, 6],
                filename: 'Laporan Data Ibu',
                title: 'Laporan Data Ibu',
            },
            excelConfiguration: {
                columns: [1, 2, 3, 4, 5, 6],
                filename: 'Laporan Data Ibu',
                title: 'Laporan Data Ibu',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4, 5, 6],
                filename: 'Laporan Data Ibu',
                title: 'Laporan Data Ibu',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
