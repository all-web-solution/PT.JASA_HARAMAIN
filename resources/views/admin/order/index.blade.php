@extends('admin.master')
@section('title', 'Order List')

@push('styles')
    <style>
        :root{--haramain-primary:#1a4b8c;--haramain-secondary:#2a6fdb;--haramain-light:#e6f0fa;--haramain-accent:#3d8bfd;--text-primary:#2d3748;--text-secondary:#4a5568;--border-color:#d1e0f5;--hover-bg:#f0f7ff;--background-light:#f8fafd;--checked-color:#2a6fdb;--success-color:#28a745;--warning-color:#ffc107;--danger-color:#dc3545;--success-bg:rgba(40, 167, 69, 0.1);--warning-bg:rgba(255, 193, 7, 0.1);--danger-bg:rgba(220, 53, 69, 0.1);--primary-bg:var(--haramain-light)}.order-list-container{max-width:100vw;margin:0 auto;padding:2rem;background-color:#f8fafd}.card{border-radius:12px;box-shadow:0 4px 12px rgb(0 0 0 / .05);border:1px solid var(--border-color);margin-bottom:2rem;overflow:hidden;transition:transform 0.3s ease,box-shadow 0.3s ease}.card:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgb(0 0 0 / .1)}.card-header{background:linear-gradient(135deg,var(--haramain-light) 0%,#ffffff 100%);border-bottom:1px solid var(--border-color);padding:1.5rem;display:flex;align-items:center;justify-content:space-between}.card-title{font-weight:700;color:var(--haramain-primary);margin:0;font-size:1.25rem;display:flex;align-items:center;gap:12px}.card-title i{font-size:1.5rem;color:var(--haramain-secondary)}.search-filter-container{display:flex;justify-content:space-between;padding:1.5rem;align-items:center;border-bottom:1px solid var(--border-color)}.search-box{position:relative;width:300px}.search-box input{padding-left:2.5rem;border-radius:8px;border:1px solid var(--border-color);height:40px;width:100%}.search-box i{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--text-secondary)}.filter-group{display:flex;gap:1rem}.btn-action,.btn-primary,.btn-outline-secondary{background-color:var(--haramain-secondary);color:#fff;border-radius:8px;padding:.625rem 1.25rem;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:all 0.3s ease;border:none;text-decoration:none;font-size:.9rem}.btn-action:hover,.btn-primary:hover{background-color:var(--haramain-primary)}.btn-outline-secondary{background-color:#fff;color:var(--text-secondary);border:1px solid var(--border-color)}.btn-outline-secondary:hover{background-color:var(--hover-bg);border-color:var(--haramain-secondary);color:var(--haramain-secondary)}.form-select,.form-control{border-radius:8px;border:1px solid var(--border-color);height:40px}.table-responsive{padding:0 1.5rem 1rem}.table{width:100%;border-collapse:separate;border-spacing:0 .75rem}.table thead th{background-color:var(--haramain-light);color:var(--haramain-primary);font-weight:600;padding:1rem 1.25rem;border-bottom:2px solid var(--border-color);text-align:center;vertical-align:middle;white-space:nowrap}.table tbody tr{background-color:#fff;transition:all 0.3s ease;border-radius:8px}.table tbody tr:hover{background-color:var(--hover-bg);box-shadow:0 4px 12px rgb(42 111 219 / .1)}.table tbody td{padding:1rem;text-align:center;vertical-align:middle;border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color)}.table tbody td.text-left{text-align:left}.table tbody td:first-child{border-left:1px solid var(--border-color);border-top-left-radius:8px;border-bottom-left-radius:8px}.table tbody td:last-child{border-right:1px solid var(--border-color);border-top-right-radius:8px;border-bottom-right-radius:8px}.badge{padding:.5rem .75rem;border-radius:6px;font-weight:700;font-size:.8rem;text-transform:capitalize}.badge-success{background-color:var(--success-bg);color:var(--success-color)}.badge-warning{background-color:var(--warning-bg);color:var(--warning-color)}.badge-danger{background-color:var(--danger-bg);color:var(--danger-color)}.badge-primary{background-color:var(--primary-bg);color:var(--haramain-secondary)}.pagination-container{display:flex;justify-content:flex-end;padding:1.5rem;border-top:1px solid var(--border-color)}.pagination .page-item.active .page-link{background-color:var(--haramain-secondary);border-color:var(--haramain-secondary);color:#fff}.pagination .page-link{color:var(--haramain-primary);border-radius:8px;margin:0 .25rem;border:1px solid var(--border-color)}@media (max-width:768px){.search-filter-container{flex-direction:column;gap:1rem;align-items:stretch}.search-box{width:100%}.filter-group{flex-wrap:wrap}.table thead{display:none}.table tbody tr{display:block;margin-bottom:1rem;border-radius:8px;box-shadow:0 2px 8px rgb(0 0 0 / .1);padding:.5rem}.table tbody td{display:flex;justify-content:space-between;align-items:center;padding:.75rem 1rem;border:none;text-align:right}.table tbody td:before{content:attr(data-label);font-weight:600;color:var(--haramain-primary);margin-right:1rem;text-align:left}.table tbody td:first-child{border-top-left-radius:8px;border-top-right-radius:8px}.table tbody td:last-child{border-bottom-left-radius:8px;border-bottom-right-radius:8px}.pagination-container{justify-content:center}}
    </style>
@endpush

@section('content')
    <div class="order-list-container">
        <div class="row g-3 mb-4 p-1" id="cards-payment">
            <x-card-component class="col-md-3" title="Total Payment" :count="$stats['total']" icon="bi bi-receipt-cutoff"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Jumlah seluruh Invoice" />
            <x-card-component class="col-md-3" title="Belum Bayar" :count="$stats['belum_bayar']" icon="bi bi-exclamation-triangle-fill"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Invoice belum dibayar" />
            <x-card-component class="col-md-3" title="Belum Lunas" :count="$stats['belum_lunas']" icon="bi bi-credit-card-2-back"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Invoice dicicil" />
            <x-card-component class="col-md-3" title="Lunas" :count="$stats['lunas']" icon="bi bi-check2-circle"
                iconColor="var(--haramain-primary)" textColor="text-primary" desc="Invoice yang sudah lunas" />
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-list-check"></i> Daftar Pesanan
                </h5>
            </div>

            <div class="search-filter-container">
                <form action="{{ route('admin.order') }}" method="GET" class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari Invoice atau Travel..."
                        value="{{ request('search') }}">
                    @foreach (request()->except(['search', 'page']) as $key => $value)
                        @if ($value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <button type="submit" class="d-none"></button>
                </form>
                <div class="filter-group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary d-flex align-items-center" type="button"
                            id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel me-2"></i> Filter
                        </button>
                        <div class="dropdown-menu dropdown-menu-end p-4 shadow" style="width: 320px;">
                            <form action="{{ route('admin.order') }}" method="GET">
                                <h6 class="fw-bold mb-3">Filters</h6>
                                <div class="mb-3">
                                    <label for="bulan" class="form-label small text-muted">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select">
                                        <option value="">-- Pilih Bulan --</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                {{ request('bulan') == $i ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tahun" class="form-label small text-muted">Tahun</label>
                                    <input type="number" name="tahun" id="tahun" class="form-control"
                                        placeholder="Tahun" value="{{ request('tahun', now()->year) }}">
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('admin.order') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                                    <button type="submit" class="btn btn-sm btn-primary">Apply filters</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Dibuat</th>
                            <th>Travel/Pelanggan</th>
                            <th>Tgl. Keberangkatan</th>
                            <th>Jml. Jamaah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @if ($orders->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                        style="height: 150px;">
                                    <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Payment</h5>
                                    <p class="text-muted">Tidak ada data ditemukan untuk filter ini.</p>
                                </td>
                            </tr>
                        @else
                            @foreach ($orders as $order)
                                @php
                                    $status = strtolower($order->status_pembayaran);
                                    $statusClass = '';
                                    if ($status == 'lunas') {
                                        $statusClass = 'badge-success';
                                    } elseif ($status == 'belum_lunas') {
                                        $statusClass = 'badge-warning';
                                    } elseif ($status == 'belum_bayar') {
                                        $statusClass = 'badge-danger';
                                    } else {
                                        $statusClass = 'badge-primary';
                                    } // 'estimasi'
                                @endphp
                                <tr>
                                    <td data-label="Invoice">{{ $order->invoice }}</td>
                                    <td data-label="Dibuat">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td data-label="Travel/Pelanggan" class="text-center">
                                        {{ $order->service?->pelanggan?->nama_travel ?? '-' }}
                                    </td>
                                    <td data-label="Tgl. Keberangkatan">
                                        {{ optional($order->service)->tanggal_keberangkatan ? \Carbon\Carbon::parse($order->service->tanggal_keberangkatan)->format('d M Y') : '-' }}
                                    </td>
                                    <td data-label="Jml. Jamaah">
                                        {{ optional($order->service)->total_jamaah ?? '-' }}
                                    </td>
                                    <td data-label="Status">
                                        <span class="badge {{ $statusClass }}">{{ $order->status_pembayaran }}</span>
                                    </td>
                                    <td data-label="Aksi">
                                        <a href="{{ route('payment.proff', $order->id) }}" class="btn-action btn-view"
                                            title="Bukti Transfer">
                                            <i class="bi bi-image"></i>
                                        </a>
                                        <a href="{{ route('order.show', $order->id) }}" class="btn-action btn-view"
                                            title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $orders->previousPageUrl() ?? '#' }}"
                                tabindex="-1">&laquo;</a>
                        </li>
                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                        <li class="page-item {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $orders->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
