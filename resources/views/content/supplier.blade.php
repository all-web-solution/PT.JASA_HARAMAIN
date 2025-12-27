@extends('admin.master')
@section('title', 'Daftar Supplier Transaksi Dokumen')

@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--background-light:#f8fafd;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545;--success-bg:rgba(40, 167, 69, 0.1);--warning-bg:rgba(255, 193, 7, 0.1);--danger-bg:rgba(220, 53, 69, 0.1);--primary-bg:var(--haramain-light)}.service-list-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:var(--background-light);min-height:100vh}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden}.card-header-styled{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.info-box{background-color:#f0f7ff;border-left:5px solid var(--haramain-secondary);padding:1.25rem;margin-bottom:1.5rem;color:var(--text-primary);border-radius:8px}.table-responsive{padding:0 1.5rem 1.5rem}.table-haramain th{background-color:var(--haramain-light);color:var(--haramain-primary);font-weight:600;padding:1rem 1.25rem;text-align:center;white-space:nowrap}.table-haramain tbody tr{background-color:#fff}.table-haramain tbody tr:hover{background-color:var(--hover-bg);box-shadow:0 4px 12px rgb(42 111 219 / .1)}.table-haramain tbody td{padding:1rem;vertical-align:middle;text-align:center;border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color)}.badge{padding:.5rem .75rem;border-radius:6px;font-weight:700;font-size:.8rem;text-transform:capitalize}.badge-success{background-color:var(--success-bg);color:var(--success-color)}.badge-warning{background-color:var(--warning-bg);color:var(--warning-color)}.badge-danger{background-color:var(--danger-bg);color:var(--danger-color)}.badge-primary{background-color:var(--primary-bg);color:var(--haramain-secondary)}.pagination-container{display:flex;justify-content:flex-end;padding:1.5rem;border-top:1px solid var(--border-color)}
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card shadow-sm">
            <div class="card-header-styled">
                <h5 class="card-title">
                    <i class="bi bi-person-lines-fill me-2"></i> Daftar Transaksi Dokumen (Supplier View)
                </h5>
            </div>

            <div class="card-body pb-0">
                <div class="info-box">
                    <p class="mb-2 small fw-bold">
                        <i class="bi bi-info-circle me-1"></i> Konteks Dokumen Master
                    </p>
                    <p class="mb-0">
                        Halaman ini menampilkan semua permintaan layanan (**Customer Document**) yang menggunakan item
                        dokumen master:
                        <span class="fw-bold text-primary">{{ $documentItem->name }}</span>
                        (Dokumen Induk: {{ $documentItem->document->name ?? 'N/A' }})
                    </p>
                    @if (isset($documentItem->is_parent_only) && $documentItem->is_parent_only)
                        <p class="mb-0 mt-2 small text-danger fw-bold">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Transaksi ini dicatat langsung ke Dokumen
                            Induk karena tidak memiliki sub-item (child).
                        </p>
                    @endif
                </div>

                @if ($customerDocuments->isEmpty())
                    <div class="text-center py-5">
                        <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data" style="height: 120px;">
                        <h5 class="mt-3" style="color: var(--haramain-primary);">Tidak Ada Permintaan Dokumen</h5>
                        <p class="text-muted">Item dokumen ini belum terpakai di layanan customer manapun.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-haramain">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Dibuat</th>
                                    <th>Nama Travel/Pelanggan</th>
                                    <th>Item Dokumen</th>
                                    <th>Jumlah</th>
                                    <th>Supplier Transaksi</th>
                                    <th>Harga Dasar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customerDocuments as $item)
                                    @php
                                        $status = strtolower($item->status);
                                        $statusClass = '';
                                        if (in_array($status, ['done', 'deal'])) {
                                            $statusClass = 'badge-success';
                                        } elseif (in_array($status, ['nego', 'tahap persiapan', 'tahap produksi'])) {
                                            $statusClass = 'badge-warning';
                                        } elseif (in_array($status, ['cancelled', 'batal'])) {
                                            $statusClass = 'badge-danger';
                                        } else {
                                            $statusClass = 'badge-primary';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration + $customerDocuments->perPage() * ($customerDocuments->currentPage() - 1) }}
                                        </td>
                                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ $item->service?->pelanggan?->nama_travel ?? 'N/A' }}</td>
                                        <td>
                                            @if ($item->documentChild?->name)
                                                {{-- Jika memiliki anak, tampilkan nama anak dan nama induk (parent) di bawahnya --}}
                                                <span class="fw-bold">{{ $item->documentChild->name }}</span>
                                                <br><small class="text-muted">({{ $item->document?->name }})</small>
                                            @else
                                                {{-- Jika tidak memiliki anak, tampilkan nama induk saja --}}
                                                <span
                                                    class="fw-bold text-danger">{{ $item->document?->name ?? 'N/A' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->jumlah ?? '-' }}</td>
                                        <td>
                                            <span class="fw-bold text-primary">{{ $item->supplier ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                SAR {{ number_format($item->harga_dasar ?? 0, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('visa.document.customer.detail', $item->id) }}"
                                                class="btn-action btn-view" title="Detail Transaksi">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="pagination-container">
                        {{ $customerDocuments->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
