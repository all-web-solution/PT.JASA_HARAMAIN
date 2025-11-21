@extends('admin.master')
@section('title', 'Daftar Pesanan Pesawat')

@push('styles')
    {{-- Gunakan style Haramain yang sudah standar --}}
    <style>
        :root {
            --haramain-primary: #1a4b8c;
            --haramain-secondary: #2a6fdb;
            --haramain-light: #e6f0fa;
            --border-color: #d1e0f5;
            --hover-bg: #f0f7ff;
        }

        .service-list-container {
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
        }

        .table tbody tr {
            background-color: white;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(42, 111, 219, 0.1);
        }

        .table tbody td {
            padding: 1.25rem;
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

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
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
                    <i class="bi bi-airplane-engines"></i> Daftar Pesanan Pesawat (Per Travel)
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Travel</th>
                            <th>Penanggung Jawab</th>
                            <th>Jumlah Pesanan</th>
                            <th>Permintaan Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($planes->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data"
                                        style="height: 150px;">
                                    <h5 class="mt-3" style="color: var(--haramain-primary);">Belum Ada Data Tiket Pesawat
                                    </h5>
                                    <p class="text-muted">Tambahkan Data Sekarang</p>
                                </td>
                            </tr>
                        @else
                            {{-- $planes di sini unik per service_id --}}
                            @foreach ($planes as $plane)
                                <tr>
                                    <td>{{ $loop->iteration + ($planes->currentPage() - 1) * $planes->perPage() }}</td>
                                    <td style="text-align: left;">
                                        {{ $plane->service->pelanggan->nama_travel ?? 'N/A' }}
                                        <br><small
                                            class="text-muted">#CUST-{{ str_pad($plane->service->pelanggan->id, 4, '0', STR_PAD_LEFT) }}</small>
                                    </td>
                                    <td>{{ $plane->service->pelanggan->penanggung_jawab ?? '-' }}</td>
                                    <td>
                                        {{-- Hitung total pesawat di service ini --}}
                                        <span class="badge bg-info text-dark">
                                            {{ \App\Models\Plane::where('service_id', $plane->service_id)->count() }}
                                            Penerbangan
                                        </span>
                                    </td>
                                    <td>{{ $plane->created_at->format('d M Y') }}</td>
                                    <td>
                                        {{-- Tombol Detail mengarah ke show($service_id) --}}
                                        <a href="{{ route('plane.show', $plane->service_id) }}" class="btn-action"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        <li class="page-item {{ $planes->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $planes->previousPageUrl() ?? '#' }}" tabindex="-1">&laquo;</a>
                        </li>

                        {{-- Page Number Links --}}
                        @foreach ($planes->getUrlRange(1, $planes->lastPage()) as $page => $url)
                            <li class="page-item {{ $planes->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        <li class="page-item {{ !$planes->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $planes->nextPageUrl() ?? '#' }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
