@extends('admin.master')

@section('content')
    <style>
        /* == Salin SEMUA CSS dari file index.blade.php Anda == */
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
            padding: 1.5rem;
            background-color: #fff;
        }

        /* Table Styles */
        .table-responsive {
            padding: 0;
            /* Hapus padding agar rata dengan card-body */
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
            /* Beri jarak antar baris */
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
            /* Bikin barisnya rounded */
        }

        .table tbody tr:hover {
            background-color: var(--hover-bg);
            box-shadow: 0 4px 12px rgba(42, 111, 219, 0.1);
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            text-align: center;
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

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f8f9fa;
            color: var(--text-secondary);
        }

        /* Add New Button (Tombol CTA) */
        .btn-add-new,
        .btn-styled {
            background-color: var(--haramain-secondary);
            color: white;
            border-radius: 8px;
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
        }

        .btn-add-new:hover,
        .btn-styled:hover {
            background-color: var(--haramain-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(26, 75, 140, 0.3);
            color: white;
            /* Pastikan warna teks tetap putih */
        }

        /* Tombol Aksi kecil (untuk tabel) */
        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Tombol Kembali */
        .btn-back {
            background-color: var(--text-secondary);
        }

        .btn-back:hover {
            background-color: var(--text-primary);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Tombol Status */
        .btn-warning {
            background-color: var(--warning-color);
            border: none;
            color: var(--text-primary);
        }

        .btn-warning:hover {
            background-color: #ffb300;
        }

        .btn-success {
            background-color: var(--success-color);
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: var(--danger-color);
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
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


        /* == CSS BARU UNTUK DETAIL LIST == */
        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            /* Responsive grid */
            gap: 1rem;
        }

        .detail-list li {
            background-color: var(--hover-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
        }

        .detail-list .detail-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--haramain-primary);
            margin-bottom: 0.25rem;
        }

        .detail-list .detail-value {
            font-size: 1rem;
            color: var(--text-secondary);
            font-weight: 500;
        }


        /* Responsive Table dari file Anda (Sudah bagus!) */
        @media (max-width: 768px) {
            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 1rem;
                border: 1px solid var(--border-color);
                box-shadow: none;
                padding: 0;
                /* Hapus padding dari tr */
            }

            .table tbody td {
                display: flex;
                /* Ubah ke flex untuk perataan */
                justify-content: space-between;
                /* Label kiri, value kanan */
                align-items: center;
                text-align: right;
                padding: 0.75rem 1rem;
                /* Padding lebih kecil */
                border: none;
                border-bottom: 1px solid var(--border-color);
                position: relative;
            }

            .table td::before {
                content: attr(data-label);
                position: static;
                /* Hapus positioning absolut */
                width: auto;
                /* Biarkan lebar otomatis */
                text-align: left;
                font-weight: 600;
                color: var(--haramain-primary);
                margin-right: 1rem;
                /* Beri jarak */
            }

            .table td:last-child {
                border-bottom: none;
            }

            .table tbody td:first-child {
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
                border-radius: 0;
            }

            .table tbody td:last-child {
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
                border-radius: 0;
            }
        }
    </style>

    <div class="service-list-container">

        {{-- KARTU DETAIL CUSTOMER (Gaya Baru) --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-person-badge"></i> Detail Customer
                </h5>
                <a href="{{ route('content.customer') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <ul class="detail-list">
                    <li>
                        <span class="detail-label">Nama Travel</span>
                        <span class="detail-value">{{ $customer->nama_travel }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Email</span>
                        <span class="detail-value">{{ $customer->email ?? '-' }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Penanggung Jawab</span>
                        <span class="detail-value">{{ $customer->penanggung_jawab ?? '-' }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Telepon</span>
                        <span class="detail-value">{{ $customer->phone ?? '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- KARTU DAFTAR KONTEN (Gaya Baru) --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="bi bi-list-check"></i> Detail Konten yang Dipesan
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- Hapus .table-striped, style dari CSS utama akan dipakai --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Konten</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Supplier</th>
                                <th>Harga Dasar</th>
                                <th>Harga Jual</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse ($customer->services as $service)
                                @foreach ($service->contents as $contentItem)
                                    <tr>
                                        <td data-label="No">{{ $no++ }}</td>
                                        <td data-label="Nama Konten">{{ $contentItem->content->name ?? 'N/A' }}</td>
                                        <td data-label="Jumlah">{{ $contentItem->jumlah }}</td>
                                        {{-- Perbaikan Typo: tanggal_pelaksanaan --}}
                                        <td data-label="Tanggal">
                                            {{ \Carbon\Carbon::parse($contentItem->tanggal_pelaksanaan)->isoFormat('D MMM Y') }}
                                        </td>
                                        <td data-label="Supplier">{{ $contentItem->supplier ?? 'Tidak ada' }}</td>
                                        <td data-label="Harga Dasar">{{ $contentItem->harga_dasar ?? 'Tidak ada' }}</td>
                                        <td data-label="Harga Jual">{{ $contentItem->harga_jual ?? 'Tidak ada' }}</td>
                                        <td data-label="Keterangan">{{ $contentItem->keterangan ?? 'Tidak ada' }}</td>
                                        <td data-label="Status">{{ $contentItem->status ?? 'Tidak ada' }}</td>
                                        <td data-label="Aksi">
                                            {{-- Tombol dengan Gaya Baru (lebih kecil) --}}
                                            <a href="{{ route('customer.edit', $contentItem->id) }}">
                                                <button class="btn-action btn-edit" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    {{-- Perbaikan Colspan --}}
                                    <td colspan="6" class="text-center" style="text-align: center; padding: 2rem;">
                                        Pelanggan ini belum memesan konten apapun.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
