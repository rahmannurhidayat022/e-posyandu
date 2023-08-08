@extends("layouts.admin")
@section("title", "Data Artikel")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Artikel Posyandu</h2>
                    <div class="mt-4">
                        <table id="article-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Diperbaharui</th>
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
                name: 'article',
                container: 'article-table',
                ajax: "{{ route('article.index') }}",
                createPageUrl: '/article/create',
                editPageUrl: '/article/{id}/edit',
                deleteActionUrl: '/article/{id}/destroy',
                hiddenExportButton: true,
                isNumber: false,
                isChild: false,
                columns: [{
                        data: 'title',
                        name: 'title',
                        render: (data, type, row) => {
                            return `<a href="/artikel/${row.slug}" target="_blank" style="text-decoration: underline">${data}</a>`
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    }
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
