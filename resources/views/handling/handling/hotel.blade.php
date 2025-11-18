@extends('admin.master')
@section('title', 'Handling Hotel')
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
        }

        .hotel-handling-container {
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

        .card-body {
            padding: 2rem;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
            margin-top: -0.75rem;
        }

        .table thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid var(--border-color);
            text-align: center;
            white-space: nowrap;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
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
            padding: 1rem;
            /* Adjusted padding for image cells */
            vertical-align: middle;
            text-align: center;
            border: 1px solid transparent;
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

        /* Image Styling in Table */
        .table tbody td img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid var(--border-color);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .table tbody td img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table tbody td span {
            color: var(--text-secondary);
            font-style: italic;
            font-size: 0.9rem;
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
    <div class="hotel-handling-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-building"></i> Data Handling Hotel
                </h5>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Customer</th>
                                <th>Nama Hotel</th>
                                <th>Tanggal</th>
                                <th>Harga</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hotels as $hotel)
                                <tr style="cursor: pointer;"
                                    onclick="window.location='{{ route('handling.handling.hotel.show', $hotel->id) }}'">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $hotel->handling->service->pelanggan->nama_travel ?? '-' }}</td>
                                    <td>{{ $hotel->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($hotel->tanggal)->translatedFormat('l, d F Y') }}</td>
                                    <td>{{ $hotel->harga }}</td>
                                    <td>{{ $hotel->supplier ?? '-' }}</td>
                                    <td>{{ $hotel->status }}</td>
                                    <td>
                                        <a href="{{ route('handling.handling.hotel.show', $hotel->id) }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('handling.hotel.edit', $hotel->id) }}" class="btn-action">
                                            {{-- Ganti # dengan route edit handling hotel --}}
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align:center; padding: 2rem;">
                                        Belum ada data handling hotel.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="pagination-container">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $hotels->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $hotels->previousPageUrl() ?? '#' }}"
                                        tabindex="-1">&laquo;</a>
                                </li>

                                {{-- Page Number Links --}}
                                @foreach ($hotels->getUrlRange(1, $hotels->lastPage()) as $page => $url)
                                    <li class="page-item {{ $hotels->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                <li class="page-item {{ !$hotels->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $hotels->nextPageUrl() ?? '#' }}">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
