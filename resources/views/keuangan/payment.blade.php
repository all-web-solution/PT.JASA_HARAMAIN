@extends('admin.master')
@section('title', 'Daftar Pembayaran Per Pelanggan')

@push('styles')
    <style>
        /* == CSS STANDARD HARAMAIN == */
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
            --success-color: #198754;
        }

        .service-list-container {
            max-width: 100vw;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--background-light);
            min-height: 100vh;
        }

        /* == CARD STYLE == */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            background-color: #fff;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
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

        /* == TABLE STYLE == */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            padding: 0;
        }

        .table-card-body {
            padding: 0 1.5rem 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--haramain-light);
            color: var(--haramain-primary);
            font-weight: 600;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid var(--border-color);
            text-align: left;
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
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
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
            background-color: var(--haramain-secondary);
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-action:hover {
            background-color: var(--haramain-primary);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Pagination Container */
        .pagination-container {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        /* == RESPONSIVE (TABLET & MOBILE) == */
        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .table thead {
                display: none;
            }

            /* Sembunyikan header di mobile */

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid var(--border-color);
                border-radius: 10px;
                padding: 0;
                overflow: hidden;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid var(--border-color);
                text-align: right;
            }

            .table tbody td:last-child {
                border-bottom: none;
            }

            /* Label Data untuk Mobile */
            .table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--haramain-primary);
                margin-right: 1rem;
                text-align: left;
                text-transform: uppercase;
                font-size: 0.75rem;
            }

            /* Reset radius */
            .table tbody tr td:first-child,
            .table tbody tr td:last-child {
                border-radius: 0;
            }

            .btn-action {
                width: 100%;
            }

            .pagination-container {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="service-list-container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-wallet2"></i> Daftar Pembayaran (Per Pelanggan)
                </h5>
            </div>

            <div class="table-card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th width="25%">kode</th>
                                <th width="20%">Nama Pelanggan / Travel</th>
                                <th width="20%">Tanggal Invoice</th>
                                <th width="25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $order)
                                <tr>
                                    <td data-label="No">{{ $loop->iteration }}</td>
                                    <td data-label="Invoice">
                                        {{ $order->invoice }}
                                    </td>
                                    <td data-label="Nama Pelanggan">
                                        {{ $order->service->pelanggan->nama_travel ?? 'Nama Tidak Ditemukan' }}
                                    </td>
                                    <td data-label="Tanggal Invoice">
                                        {{ $order->created_at->format('d M y') ?? 'Nama Tidak Ditemukan' }}
                                    </td>
                                    <td data-label="Aksi">
                                        {{-- Link ke Detail Payment --}}
                                        <a href="{{ route('keuangan.payment.detail', $order->service_id) }}"
                                            class="btn-action">
                                            <i class="bi bi-eye-fill"></i> Lihat Detail & Bayar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5" style="color: var(--text-secondary);">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        Belum ada data pembayaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Container --}}
            {{-- Catatan: Karena $data adalah Collection (hasil ->unique),
                 fungsi ->links() standar tidak akan muncul kecuali Anda melakukan manual pagination
                 atau mengubah controller menjadi groupBy + paginate.
                 Saya sertakan containernya untuk konsistensi tampilan. --}}
            @if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="pagination-container">
                    {{ $data->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
