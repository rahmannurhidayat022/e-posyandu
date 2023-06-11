@extends("layouts.admin")
@section("title", "Dashboard")

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
                                    <td>No</td>
                                    <td>Username</td>
                                    <td>Role</td>
                                    <td>Dibuat</td>
                                    <td>Diperbaharui</td>
                                    <td>Aksi</td>
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
    $(document).ready(function() {
        const table = window.initialDataTable({
            tableConfiguration: {
                name: 'admin',
                container: 'admin-table',
                ajax: "{{ route('admin.index') }}",
                createPageUrl: '/posko/create',
                editPageUrl: '/posko/{id}/edit',
                deleteActionUrl: '/posko/{id}/destroy',
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
