@extends('admin.master')

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
            flex-wrap: wrap; /* Tambahkan untuk responsif */
            gap: 1rem; /* Tambahkan jarak jika wrap */
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
            padding: 0 1.5rem;
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
            text-align: left; /* Pastikan rata kiri */
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
            padding: 1.25rem;
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

        /* ... [CSS Anda yang lain seperti .badge, .customer-info, dll] ... */

        .customer-info {
            display: flex;
            align-items: center;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--haramain-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--haramain-secondary);
            font-size: 1.25rem;
            flex-shrink: 0; /* Agar avatar tidak menyusut */
        }

        .customer-details {
            line-height: 1.4;
        }

        .customer-name {
            font-weight: 600;
            color: var(--haramain-primary);
        }

        .customer-type {
            font-size: 0.75rem;
            color: var(--text-secondary);
            background-color: var(--haramain-light);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }

        /* ... [CSS Anda yang lain] ... */

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
            text-decoration: none; /* Tambahkan untuk link <a> */
            white-space: nowrap; /* Agar teks tidak terpotong */
        }

        .btn-add-new:hover {
            background-color: var(--haramain-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(26, 75, 140, 0.3);
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
            color: white; /* Pastikan teksnya putih */
        }

        .pagination .page-link {
            color: var(--haramain-primary);
            border-radius: 8px;
            margin: 0 0.25rem;
            border: 1px solid var(--border-color);
        }

        /* Responsive adjustments - BLOK GABUNGAN */
        @media (max-width: 768px) {
            .service-list-container {
                padding: 1rem;
            }

            .card-header, .search-filter-container {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
                text-align: center;
                justify-content: center;
            }

            .btn-add-new {
                width: 100%;
                justify-content: center;
            }

            .search-box {
                width: 100%;
            }

            .filter-group {
                width: 100%;
                flex-wrap: wrap;
            }

            .filter-select {
                width: 100%;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1.5rem;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                border: 1px solid var(--border-color);
            }

            .table tbody td {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                justify-content: center;
                text-align: left;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid var(--border-color);
            }

            .table tbody tr td:last-child {
                border-bottom: none;
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--haramain-primary);
                margin-bottom: 0.5rem;
                font-size: 0.8rem;
                text-transform: uppercase;
            }

            .table tbody td:first-child {
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }

            .table tbody td:last-child {
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
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
                <h5 class="card-title" id="text-title">
                    <i class="bi bi-list-check"></i>
                    {{-- Periksa apakah relasi ada sebelum mengaksesnya --}}
                    Daftar Bukti transfer {{ $order->service->pelanggan->nama_travel ?? 'Customer' }}
                </h5>
                <a href="{{ route('payment.proff.create', $order->id) }}" class="btn-add-new">
                    <i class="bi bi-plus-circle"></i> Tambah bukti pembayaran
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Nomor Telepon</th>
                            <th>Bukti Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Gunakan @forelse untuk menangani kasus data kosong --}}
                        @forelse ($paymentPreff as $payment)
                            <tr>
                                <td data-label="No.">{{ $loop->iteration }}</td>
                                <td data-label="Customer">
                                    <div class="customer-info">
                                        <div class="customer-avatar">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div class="customer-details">
                                            <div class="customer-name">{{ $order->service->pelanggan->nama_travel ?? '-' }}</div>
                                            <div class="customer-type">{{ $order->service->pelanggan->penanggung_jawab ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Nomor telepon">{{ $order->service->pelanggan->phone ?? '-' }}</td>
                                <td data-label="Bukti pembayaran">
                                    {{-- Gunakan helper asset() untuk path storage --}}
                                    <a href="{{ url('storage/' . $payment->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Pembayaran"
                                            style="max-width: 100px; max-height: 100px; border-radius: 8px;">
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- Sesuaikan jumlah kolom (colspan) dengan header tabel Anda --}}
                                <td colspan="4" style="text-align: center; padding: 2rem; border-radius: 8px;">
                                    Belum ada bukti pembayaran yang diupload.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tampilkan pagination hanya jika ada lebih dari 1 halaman --}}


        </div>
    </div>
@endsection


