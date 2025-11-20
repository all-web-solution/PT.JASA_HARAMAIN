@extends('admin.master')
@section('title', 'Daftar Dokumen')
@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--background-light:#f8fafd;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545;--success-bg:rgba(40, 167, 69, 0.1);--warning-bg:rgba(255, 193, 7, 0.1);--danger-bg:rgba(220, 53, 69, 0.1);--primary-bg:var(--haramain-light)}.service-list-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:var(--background-light)}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.btn-add-new{background-color:var(--haramain-secondary);color:#fff;padding:.6rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:background-color 0.3s ease,box-shadow 0.3s ease}.btn-add-new:hover{background-color:var(--haramain-primary);box-shadow:0 4px 12px rgb(42 111 219 / .2)}.table-responsive{padding:0 1.5rem 1.5rem}.table{width:100%;border-collapse:separate;border-spacing:0 .75rem}.table thead th{background-color:var(--haramain-light);color:var(--haramain-primary);font-weight:600;padding:1rem 1.25rem;border-bottom:2px solid var(--border-color);text-align:center;white-space:nowrap}.table tbody tr{background-color:#fff;transition:all 0.3s ease;border-radius:8px}.table tbody tr:hover{background-color:var(--hover-bg);box-shadow:0 4px 12px rgb(42 111 219 / .1);transform:translateY(-2px)}.table tbody td{padding:1.25rem;vertical-align:middle;text-align:center;border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color)}.table tbody tr td:first-child{border-left:1px solid var(--border-color);border-top-left-radius:8px;border-bottom-left-radius:8px}.table tbody tr td:last-child{border-right:1px solid var(--border-color);border-top-right-radius:8px;border-bottom-right-radius:8px}.actions-container{display:flex;gap:.5rem;align-items:center;justify-content:center}.btn-action{width:32px;height:32px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;margin:0;transition:all 0.3s ease;border:none;background-color:#fff0;color:var(--text-secondary)}.btn-action:hover{background-color:var(--haramain-light);color:var(--haramain-secondary)}.actions-container .btn-action.text-info{color:var(--haramain-secondary)}.actions-container .btn-action.text-warning{color:var(--warning-color)}.actions-container .btn-action.text-danger{color:var(--danger-color)}
    </style>
@endpush
@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-text-fill"></i>Daftar Dokumen
                </h5>
                <a href="{{ route('visa.document.create') }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah Dokumen
                </a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="text-align: left;">Nama</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $doc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: left;">{{ $doc->name }}</td>
                                <td>
                                    <div class="actions-container">
                                        <a href="{{ route('visa.document.show', $doc->id) }}" class="btn-action text-info"
                                            title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('visa.document.edit', $doc->id) }}"
                                            class="btn-action text-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form id="delete-form-{{ $doc->id }}"
                                            action="{{ route('visa.document.delete', $doc->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn-action delete-confirm text-danger"
                                                data-id="{{ $doc->id }}" data-nama="{{ $doc->name }}"
                                                title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center; padding: 2rem;">
                                    Belum ada data dokumen yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-confirm');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const docId = this.getAttribute('data-id');
                    const docName = this.getAttribute('data-nama');
                    const formId = 'delete-form-' + docId;

                    Swal.fire({
                        title: 'Anda Yakin?',
                        // KODE YANG DIMODIFIKASI
                        html: `
                            Anda akan menghapus dokumen master: <strong>${docName}</strong>.<br><br>
                            <span style="color: var(--danger-color); font-weight: bold;">PERINGATAN KERAS:</span> Tindakan ini akan menyebabkan <strong style="color: var(--danger-color);">KEHILANGAN DATA PERMANEN</strong> pada semua data yang terkait, termasuk:
                            <ul>
                                <li>Semua sub-item dokumen (Document Children) yang dibuat di bawahnya.</li>
                                <li>Semua catatan permintaan layanan (Customer Document) yang terkait dengan dokumen ini di semua transaksi customer.</li>
                            </ul>
                            Pastikan tidak ada transaksi aktif yang mengandalkan data ini. Aksi ini tidak bisa dikembalikan!
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus Permanen!',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(formId).submit();
                        }
                    });
                });
            });

            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });
    </script>
@endpush
