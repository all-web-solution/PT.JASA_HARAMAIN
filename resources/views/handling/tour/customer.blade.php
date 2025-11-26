@extends('admin.master')
@section('title', 'Daftar Order Tour Customer')

@push('styles')
    <style>
        /* == CSS Dari Referensi 'index dokumen' == */
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
            /* Sesuai referensi */
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
            vertical-align: middle;
            text-align: center;
            /* Sesuai referensi */
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

        /* Action Buttons */
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

        .btn-edit {
            color: var(--haramain-secondary);
        }

        .btn-view {
            color: var(--text-secondary);
        }

        .btn-delete {
            color: var(--danger-color);
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
            padding: 0 1.5rem 1.5rem;
            display: flex;
            justify-content: flex-end;
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
            margin-top: 1rem;
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
                    {{-- Ganti Icon dan Judul --}}
                    <i class="bi bi-map-fill"></i>Daftar Order Tour
                </h5>
                {{-- <a href="{{ route('tour.create') }}" class="btn-add-new">...</a> --}}
            </div>

            {{-- Ganti padding <table> dari referensi --}}
            <div class.table-responsive" style="padding: 0 1.5rem 1.5rem;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Travel</th>
                            <th>Tgl Keberangkatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ganti variabel $tours menjadi $tours --}}
                        @forelse ($tours as $tour)
                            {{-- $tour adalah instance dari Model Tour --}}

                            @php
                                $status = strtolower($tour->status);
                                $statusClass = '';
                                if (in_array($status, ['done', 'deal'])) {
                                    $statusClass = 'badge-success';
                                } elseif (in_array($status, ['pending', 'nego', 'tahap persiapan'])) {
                                    $statusClass = 'badge-warning';
                                } elseif (in_array($status, ['cancelled', 'batal'])) {
                                    $statusClass = 'badge-danger';
                                } else {
                                    $statusClass = 'badge-primary';
                                }
                            @endphp

                            <tr>
                                {{-- Nomor Paginasi --}}
                                <td>{{ ($tours->currentPage() - 1) * $tours->perPage() + $loop->iteration }}</td>

                                {{-- Kolom Nama Pelanggan --}}
                                <td>
                                    {{ $tour->service?->pelanggan?->nama_travel ?? 'N/A' }}
                                </td>

                                {{-- Kolom Tanggal Keberangkatan --}}
                                <td>{{ \Carbon\Carbon::parse($tour->tanggal_keberangkatan)->isoFormat('D MMM Y') }}</td>

                                {{-- Kolom Status --}}
                                <td>
                                    <span class="badge {{ $statusClass }}">{{ $tour->status }}</span>
                                </td>

                                {{-- Kolom Aksi --}}
                                <td>
                                    {{-- Ganti 'tour.show' & 'tour.edit' dengan nama route Anda --}}
                                    <a href="{{ route('tour.customer.show', $tour->service_id) }}" class="btn-action btn-view"
                                        title="View">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 2rem;">
                                    Tidak ada data order tour ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        <li class="page-item {{ $tours->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $tours->previousPageUrl() ?? '#' }}" tabindex="-1">&laquo;</a>
                        </li>

                        {{-- Page Number Links --}}
                        @foreach ($tours->getUrlRange(1, $tours->lastPage()) as $page => $url)
                            <li class="page-item {{ $tours->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        <li class="page-item {{ !$tours->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $tours->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
