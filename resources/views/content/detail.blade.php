@extends('admin.master')
@section('title', 'Detail Dokumen')
@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--background-light:#f8fafd;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545;--success-bg:rgba(40, 167, 69, 0.1);--warning-bg:rgba(255, 193, 7, 0.1);--danger-bg:rgba(220, 53, 69, 0.1);--primary-bg:var(--haramain-light)}.document-detail-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:var(--background-light)}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.card-body{padding:2rem}.detail-section p{font-size:1.1rem;color:var(--text-primary)}.detail-section p strong{color:var(--text-secondary);font-weight:600}.table-responsive{overflow-x:auto}.table{width:100%;border-collapse:separate;border-spacing:0 .75rem;margin-top:-.75rem}.table thead th{background-color:var(--haramain-light);color:var(--haramain-primary);font-weight:600;padding:1rem 1.25rem;border-bottom:2px solid var(--border-color);text-align:center;white-space:nowrap}.table tbody tr{background-color:#fff;transition:all 0.3s ease;border-radius:8px}.table tbody tr:hover{background-color:var(--hover-bg);box-shadow:0 4px 12px rgb(42 111 219 / .1);transform:translateY(-2px)}.table tbody td{padding:1.25rem;vertical-align:middle;border:1px solid #fff0;border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);text-align:center}.table tbody tr td:first-child{border-left:1px solid var(--border-color);border-top-left-radius:8px;border-bottom-left-radius:8px;text-align:left}.table tbody tr td:last-child{border-right:1px solid var(--border-color);border-top-right-radius:8px;border-bottom-right-radius:8px}.actions-container{display:flex;gap:.5rem;align-items:center;justify-content:center}.btn-action-icon{width:32px;height:32px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;margin:0;transition:all 0.3s ease;border:none;background-color:#fff0;color:var(--text-secondary)}.btn-action-icon:hover{background-color:var(--haramain-light);color:var(--haramain-secondary)}.text-info{color:var(--haramain-secondary)}.text-warning{color:var(--warning-color)}.text-danger{color:var(--danger-color)}.text-secondary{color:var(--text-secondary)}
    </style>
@endpush
@section('content')
    <div class="document-detail-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-file-earmark-text"></i>Detail Dokumen Master
                </h5>
                <div class="actions-container">

                    @if ($childrens->isEmpty())
                        <a href="{{ route('visa.document.supplier.parent', $document->id) }}"
                            class="btn-action-icon text-info" title="Lihat Daftar Global Supplier Transaksi">
                            <i class="bi bi-truck"></i>
                        </a>
                    @endif

                    <a href="{{ route('visa.document.edit', $document->id) }}" class="btn-action-icon text-warning"
                        title="Edit Dokumen Induk">
                        <i class="bi bi-pencil-fill"></i>
                    </a>

                    <a href="{{ route('visa.document.index') }}" class="btn-action-icon text-secondary"
                        title="Kembali ke Daftar Dokumen">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="detail-section mb-4">
                    <p><strong>Nama Dokumen Induk:</strong> {{ $document->name }}</p>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title" style="font-size: 1rem; margin: 0;">
                        <i class="bi bi-list-nested" style="font-size: 1.25rem;"></i>
                        {{ $childrens->isNotEmpty() ? 'Daftar Sub-Item Dokumen' : 'Dokumen Ini Tidak Memiliki Sub-Item' }}
                    </h6>
                    <div class="actions-container">
                        <a href="{{ route('visa.document.show.create', $document->id) }}" class="btn-action-icon text-info"
                            title="Tambah Sub-Item">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                    </div>
                </div>


                @if ($childrens->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="text-align: left;">Nama Sub-Item</th>
                                    <th>Harga Jual Bawaan</th>
                                    <th style="width: 300px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($childrens as $child)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $child->name }}</td>
                                        <td>SAR {{ number_format($child->price, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="actions-container">
                                                <a href="{{ route('visa.document.customer.detail.supplier', $child->id) }}"
                                                    class="btn-action-icon text-info" title="Daftar Global Supplier Item">
                                                    <i class="bi bi-truck"></i>
                                                </a>

                                                <a href="{{ route('visa.document.show.edit', $child->id) }}"
                                                    class="btn-action-icon text-warning" title="Edit Sub-Item">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>

                                                <form id="delete-child-form-{{ $child->id }}"
                                                    action="{{ route('visa.document.show.delete', $child->id) }}"
                                                    method="post" style="display: inline;">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="button" class="btn-action-icon text-danger"
                                                        onclick="confirmDelete('delete-child-form-{{ $child->id }}', '{{ $child->name }}')"
                                                        title="Hapus Sub-Item">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        Dokumen ini diperlakukan sebagai item tunggal untuk transaksi.
                        @if ($document->id)
                            <br>Untuk melihat riwayat supplier, gunakan tombol
                            <a href="{{ route('visa.document.supplier.parent', $document->id) }}"
                                class="btn-action-icon text-info" title="Daftar Global Supplier (Dokumen Induk)">
                                <i class="bi bi-truck"></i>
                            </a>
                            di bagian header.
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function confirmDelete(formId, itemName) {
            event.preventDefault();

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Sub-item " + itemName + " akan dihapus. Semua data transaksi terkait AKAN TERDAMPAK!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false,
            timerProgressBar: true
        });
        @endif
    </script>
@endpush
