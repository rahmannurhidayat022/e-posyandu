@extends("layouts.admin")
@section("title", "Admin")

@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-semibold mb-4">Manajemen akun admin</h2>
                    <div class="mt-4">
                        <table id="admin-table" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Dibuat</th>
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
                name: 'admin',
                container: 'admin-table',
                ajax: "{{ route('admin.index') }}",
                createPageUrl: '/admin/create',
                editPageUrl: '/admin/{id}/edit',
                deleteActionUrl: '/admin/{id}/destroy',
                isNumber: true,
                isChild: false,
                columns: [{
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'role',
                        name: 'role',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                    },
                ]
            },
            printConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Admin',
                title: 'Laporan Data Admin',
            },
            excelConfiguration: {
                columns: [0, 1, 2, 3, 4],
                filename: 'Laporan Data Admin',
                title: 'Laporan Data Admin',
            },
            pdfConfiguration: {
                orientation: 'potrait',
                pageSize: 'A4',
                columns: [1, 2, 3, 4],
                filename: 'Laporan Data Admin',
                title: 'Laporan Data Admin',
                isRt: false,
            },
        })
    });
</script>
@endpush
@endsection
