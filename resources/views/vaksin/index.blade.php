@extends("layouts.admin")
@section("title", "Vaksin")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Data Vaksin Imunisasi Anak</h2>
                    <div class="mt-4">
                        <table id="vaksin-table" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Varian</th>
                                    <th>Nomor Batch</th>
                                    <th>Kedaluarsa</th>
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
                name: 'vaksin',
                container: 'vaksin-table',
                ajax: "{{ route('vaksin.index') }}",
                createPageUrl: '/vaksin/create',
                editPageUrl: '/vaksin/{id}/edit',
                deleteActionUrl: '/vaksin/{id}/destroy',
                isNumber: false,
                isChild: false,
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type',
                    },
                    {
                        data: 'variant',
                        name: 'variant',
                    },
                    {
                        data: 'batch_number',
                        name: 'batch_number',
                    },
                    {
                        data: 'expired_date',
                        name: 'expired_date',
                    },

                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Vaksin',
                title: 'Laporan Data Vaksin',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Vaksin',
                title: 'Laporan Data Vaksin',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Vaksin',
                title: 'Laporan Data Vaksin',
                isRt: true,
            },
        })
    })
</script>
@endpush
@endsection
