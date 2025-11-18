@extends('admin.master')
@section('title', 'Daftar Dokumen dan Permit Customer')
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
            --background-light: #f8fafd;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --success-bg: rgba(40, 167, 69, 0.1);
            --warning-bg: rgba(255, 193, 7, 0.1);
            --danger-bg: rgba(220, 53, 69, 0.1);
            --primary-bg: var(--haramain-light);
        }

        .service-list-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            overflow: hidden;
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

        /* Table Styles */
        .table-responsive {
            padding: 0 1.5rem 1.5rem;
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
            white-space: nowrap;
        }

        .table tbody tr {
            background-color: white;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            box-shadow: 0 4px 12px rgba(42, 111, 219, 0.1);
            transform: translateY(-2px);
        }

        .table tbody td {
            padding: 1.25rem;
            /* Padding seragam */
            vertical-align: middle;
            text-align: center;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table tbody tr td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Tombol Aksi */

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            border: none;
            background-color: transparent;
        }

        .btn-action:hover {
            background-color: var(--haramain-light);
        }

        .btn-action i {
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--haramain-secondary);
            border-color: var(--haramain-secondary);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--haramain-primary);
            border-color: var(--haramain-primary);
        }

        /* Badge Status */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: capitalize;
        }

        .badge-success {
            background-color: var(--success-bg);
            color: var(--success-color);
        }

        .badge-warning {
            background-color: var(--warning-bg);
            color: var(--warning-color);
        }

        .badge-danger {
            background-color: var(--danger-bg);
            color: var(--danger-color);
        }

        .badge-primary {
            background-color: var(--primary-bg);
            color: var(--haramain-secondary);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--haramain-secondary);
            border-color: var(--haramain-secondary);
        }

        .pagination .page-link {
            color: var(--haramain-primary);
            border-radius: 8px;
            margin: 0 0.25rem;
            border: 1px solid var(--border-color);
        }
    </style>
@endpush
@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-vcard"></i>Daftar Dokumen & Permit Customer
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Nama Dokumen</th>
                            <th>Jumlah</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($customers->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                        style="height: 150px;">
                                    <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Permintaan
                                        Dokumen</h5>
                                    <p class="text-muted">Tunggu permintaan dari admin</p>
                                </td>
                            </tr>
                        @else
                            {{-- Pastikan $customers adalah variabel dari controller --}}
                            @foreach ($customers as $item)
                                {{-- $item adalah instance dari CustomerDocument --}}

                                {{-- Logika untuk menentukan warna badge --}}
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
                                    <td>{{ $loop->iteration }}</td>

                                    {{-- Ambil dari relasi service -> pelanggan --}}
                                    <td>{{ $item->service?->pelanggan?->nama_travel ?? 'N/A' }}</td>

                                    {{-- Ambil dari relasi document --}}
                                    @if ($item->documentChild?->name)
                                        <td>{{ $item->documentChild?->name ?? 'N/A' }}</td>
                                    @else
                                        <td>{{ $item->document?->name ?? 'N/A' }}</td>
                                    @endif

                                    {{-- Ambil LANGSUNG dari $item --}}
                                    <td>{{ $item->jumlah }}</td>

                                    {{-- Ambil LANGSUNG dari $item --}}
                                    <td>{{ $item->supplier ?? '-' }}</td>

                                    {{-- Ambil LANGSUNG dari $item dan beri badge --}}
                                    <td>
                                        <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                                    </td>

                                    <td>
                                        <a href="{{ route('visa.document.customer.detail', $item->id) }}"> <button
                                                class="btn-action btn-view" title="view">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('document.customer.edit', $item->id) }}" class="btn-action">
                                            <i class="bi bi-pencil-fill"></i>
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
                        <li class="page-item {{ $customers->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $customers->previousPageUrl() ?? '#' }}"
                                tabindex="-1">&laquo;</a>
                        </li>

                        {{-- Page Number Links --}}
                        @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                            <li class="page-item {{ $customers->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        <li class="page-item {{ !$customers->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $customers->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
