@extends('admin.master')
@section('title', 'Order List')
@section('content')
    @push('styles')
        <style>
            :root {
                --haramain-primary: #1a4b8c;
                --haramain-secondary: #2a6fdb;
                --haramain-light: #e6f0fa;
                --haramain-accent: #3d8bfd;
                --text-primary: #2d3748;
                --text-secondary: #4a5568;
                --border-color: #d1e0f5;
                --hover-bg: #f0f7ff;
                --checked-color: #2a6fdb;
                --success-color: #28a745;
                --warning-color: #ffc107;
                --danger-color: #dc3545;
            }

            .order-list-container {
                max-width: 100vw;
                margin: 0 auto;
                padding: 2rem;
                background-color: #f8fafd;
            }

            .card {
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--border-color);
                margin-bottom: 2rem;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card-header {
                background: linear-gradient(135deg, var(--haramain-light) 0%, #ffffff 100%);
                border-bottom: 1px solid var(--border-color);
                padding: 1.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .card-title {
                font-weight: 700;
                color: var(--haramain-primary);
                margin: 0;
                font-size: 1.25rem;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .card-title i {
                font-size: 1.5rem;
                color: var(--haramain-secondary);
            }

            /* Search and Filter */
            .search-filter-container {
                display: flex;
                justify-content: space-between;
                padding: 1.5rem;
                align-items: center;
                border-bottom: 1px solid var(--border-color);
            }

            .search-box {
                position: relative;
                width: 300px;
            }

            .search-box input {
                padding-left: 2.5rem;
                border-radius: 8px;
                border: 1px solid var(--border-color);
                height: 40px;
                width: 100%;
            }

            .search-box i {
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: var(--text-secondary);
            }

            /* Table style */
            .table-responsive {
                padding: 0 1.5rem 1rem;
            }

            .table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0 0.75rem;
            }

            .table thead th {
                background-color: var(--haramain-light);
                color: var(--haramain-primary);
                font-weight: 600;
                padding: 1rem 1.25rem;
                border-bottom: 2px solid var(--border-color);
                text-align: center;
                vertical-align: middle;
            }

            .table tbody tr {
                background-color: white;
                transition: all 0.3s ease;
                border-radius: 8px;
            }

            .table tbody tr:hover {
                background-color: var(--hover-bg);
                box-shadow: 0 4px 12px rgba(42, 111, 219, 0.1);
            }

            .table tbody td {
                padding: 1rem;
                text-align: center;
                vertical-align: middle;
                border-top: 1px solid var(--border-color);
                border-bottom: 1px solid var(--border-color);
            }

            .table tbody td:first-child {
                border-left: 1px solid var(--border-color);
                border-top-left-radius: 8px;
                border-bottom-left-radius: 8px;
            }

            .table tbody td:last-child {
                border-right: 1px solid var(--border-color);
                border-top-right-radius: 8px;
                border-bottom-right-radius: 8px;
            }

            .badge {
                padding: 0.5rem 0.75rem;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.75rem;
            }

            .btn-add-new {
                background-color: var(--haramain-secondary);
                color: white;
                border-radius: 8px;
                padding: 0.625rem 1.5rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all 0.3s ease;
                border: none;
            }

            /* Pagination */
            .pagination-container {
                display: flex;
                justify-content: flex-end;
                padding: 1.5rem;
                border-top: 1px solid var(--border-color);
                gap: 1rem;
            }

            .pagination .page-link {
                border-radius: 10px;
                margin: 0 3px;
                color: var(--haramain-primary);
                border-color: #d9e3f0;
            }

            .pagination .page-item.active .page-link {
                background-color: #2f6fed;
                border-color: #2f6fed;
                color: #fff;
            }

            .pagination .page-item.disabled .page-link {
                background-color: #f5f7fa;
                color: #adb5bd;
                border-color: #e3e7ec;
            }

            #card-payment {
                width: 100%;
            }


            /* ✅ Responsive Umum (Tablet) */
            @media (max-width: 768px) {
                .search-filter-container {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: flex-start;
                }

                .search-box {
                    width: 100%;
                }

                .filter-group {
                    width: 100%;
                    flex-wrap: wrap;
                }

                .table thead {
                    display: none;
                }

                .table tbody tr {
                    display: block;
                    margin-bottom: 1rem;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    padding: 0.5rem;
                }

                .table tbody td {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.5rem 1rem;
                    border: none;
                    text-align: center;
                }

                .table tbody td:before {
                    content: attr(data-label);
                    font-weight: 600;
                    color: var(--haramain-primary);
                    margin-right: 1rem;
                }
            }

            /* ✅ Responsive untuk layar kecil (≤ 320px) */
            @media (max-width: 320px) {
                #filter {
                    display: none;
                }

                .order-list-container {
                    padding: 1rem;
                }

                .card-header {
                    flex-direction: column;
                    align-items: flex-start;
                    padding: 1rem;
                }

                .card-title {
                    font-size: 1rem;
                    gap: 6px;
                }

                .search-filter-container {
                    padding: 1rem;
                    flex-direction: column;
                    gap: 0.75rem;
                }

                .search-box input {
                    height: 36px;
                    font-size: 0.85rem;
                }

                .filter-group {
                    flex-direction: column;
                    width: 100%;
                }

                .filter-select {
                    width: 100%;
                    font-size: 0.8rem;
                    height: 36px;
                }

                .table-responsive {
                    padding: 0.5rem;
                    overflow-x: auto;
                }

                .table tbody tr {
                    margin-bottom: 0.75rem;
                }

                .table tbody td {
                    padding: 0.5rem;
                    font-size: 0.8rem;
                    flex-direction: column;
                    align-items: flex-start;
                }

                .table tbody td:before {
                    font-size: 0.75rem;
                    margin-bottom: 0.25rem;
                }

                .btn {
                    font-size: 0.75rem;
                    padding: 0.4rem 0.75rem;
                }

                .pagination-container {
                    justify-content: center;
                    padding: 0.75rem;
                }

                .pagination .page-link {
                    font-size: 0.75rem;
                    padding: 0.4rem 0.6rem;
                }
            }
        </style>
    @endpush

    <div class="order-list-container">
        <div class="row g-3 mb-4 p-1" id="cards-payment">
            <x-card-component class="col-md-4" title="Total Payment" :count="\App\Models\Order::count()" icon="bi bi-receipt-cutoff"
                {{-- Icon Struk/Invoice Total --}} iconColor="var(--haramain-primary)" textColor="text-primary"
                desc="Jumlah seluruh Invoice" />

            <x-card-component class="col-md-4" title="Belum Bayar" :count="\App\Models\Order::where('status_pembayaran', 'belum_bayar')->count()" icon="bi bi-exclamation-triangle-fill"
                {{-- Icon Peringatan/Pending --}} iconColor="var(--haramain-primary)" {{-- Sesuaikan warna ikon jika perlu --}} textColor="text-primary"
                {{-- Sesuaikan warna teks jika perlu --}} desc="Invoice yang belum lunas" />

            <x-card-component class="col-md-4" title="Lunas" :count="\App\Models\Order::where('status_pembayaran', 'lunas')->count()" icon="bi bi-check2-circle"
                {{-- Icon Selesai/Lunas --}} iconColor="var(--haramain-primary)" {{-- Sesuaikan warna ikon jika perlu --}} textColor="text-primary"
                desc="Invoice yang sudah lunas" />
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-list-check"></i> Daftar Pesanan
                </h5>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-container">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari customer/kode service...">
                </div>
                <div class="filter-group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary d-flex align-items-center" type="button"
                            id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel me-2"></i> Filter
                        </button>

                        <!-- Dropdown Filter -->
                        <div class="dropdown-menu dropdown-menu-end p-4 shadow" style="width: 320px;">
                            <form action="{{ route('admin.order') }}" method="GET">
                                <h6 class="fw-bold mb-3">Filters</h6>

                                <!-- Bulan -->
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

                                <!-- Tahun -->
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
                            <th>Nama Pelanggan</th>
                            <th>Tagihan</th>
                            <th>Dibayar</th>
                            <th>Sisa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @if ($orders->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                        style="height: 150px;">
                                    <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Payment</h5>
                                    <p class="text-muted">Mulai dengan menambahkan permintaan di service</p>
                                </td>
                            </tr>
                        @else
                            @foreach ($orders as $order)
                                <tr>
                                    <td data-label="Invoice">{{ $order->invoice }}</td>
                                    <td data-label="Nama Pelanggan">{{ $order->service?->pelanggan?->nama_travel ?? '-' }}
                                    </td>
                                    <td data-label="Total">{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td data-label="Dibayar">
                                        {{ number_format($order->total_yang_dibayarkan, 0, ',', '.') }}
                                    </td>
                                    <td data-label="Sisa">{{ number_format($order->sisa_hutang, 0, ',', '.') }}</td>
                                    <td data-label="Aksi">
                                        <a href="{{ route('payment.proff', $order->id) }}" class="btn btn-primary">
                                            Bukti transfer
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
                        {{-- Previous Page Link --}}
                        <li class="page-item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $orders->previousPageUrl() ?? '#' }}" tabindex="-1">&laquo;</a>
                        </li>

                        {{-- Page Number Links --}}
                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        <li class="page-item {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $orders->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Improved Search Functionality
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('userTableBody');
            const rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    // Get all text content from the row, not just specific cells
                    const rowText = row.textContent.toLowerCase();

                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
@endsection
